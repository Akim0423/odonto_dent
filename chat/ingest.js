require('dotenv').config();
const mysql = require('mysql2/promise');
const { GoogleGenerativeAIEmbeddings } = require('@langchain/google-genai');
const { Chroma } = require('@langchain/community/vectorstores/chroma');
const { RecursiveCharacterTextSplitter } = require('langchain/text_splitter');

async function ingestData() {
    console.log('Iniciando la ingesta de datos...');
    const connection = await mysql.createConnection({
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASSWORD,
        database: process.env.DB_NAME,
    });

    // Obtener datos clave de varias tablas
    const [ajustes] = await connection.execute('SELECT telefono, direccion, zona_horaria FROM ajustes');
    const [clientes] = await connection.execute('SELECT id, nombre, email, documento, telefono, direccion FROM clientes');
    const [citas] = await connection.execute('SELECT id, id_doctor, id_cliente, inicio, fin, nota, estado FROM citas');
    const [historial] = await connection.execute('SELECT id, id_doctor, id_cliente, id_cita, fecha, nota FROM historial_clinico');
    const [recetas] = await connection.execute('SELECT id, id_cita, receta FROM recetas');
    const [users] = await connection.execute('SELECT id, name, email, rol FROM users');
    // Mapas auxiliares para obtener nombres desde los IDs
    const mapClientes = Object.fromEntries(clientes.map(c => [c.id, c.nombre]));
    const mapDoctores = Object.fromEntries(users.filter(u => u.rol === 'doctor').map(d => [d.id, d.name]));


    connection.end();

    const documentos = [];

    // Ajustes generales
    ajustes.forEach(row => {
        documentos.push({
            pageContent: `Información del consultorio: Teléfono ${row.telefono}, Dirección ${row.direccion}, Zona horaria: ${row.zona_horaria}.`,
            metadata: { tipo: 'ajustes' }
        });
    });

    // Clientes
    clientes.forEach(c => {
        documentos.push({
            pageContent: `Cliente: ${c.nombre}, Documento: ${c.documento}, Teléfono: ${c.telefono}, Dirección: ${c.direccion}.`,
            metadata: { tipo: 'cliente', id: c.id }
        });
    });

    // Citas
    citas.forEach(cita => {
        const nombreCliente = mapClientes[cita.id_cliente] || `ID ${cita.id_cliente}`;
        const nombreDoctor = mapDoctores[cita.id_doctor] || `ID ${cita.id_doctor}`;

        documentos.push({
            pageContent: `Cita ID ${cita.id}: Cliente ${nombreCliente}, Doctor ${nombreDoctor}, Inicio: ${cita.inicio}, Fin: ${cita.fin}, Estado: ${cita.estado}, Nota: ${cita.nota}.`,
            metadata: { tipo: 'cita', id: cita.id }
        });
    });


    // Historial clínico
    historial.forEach(h => {
        documentos.push({
            pageContent: `Historial clínico ID ${h.id}: Doctor ID ${h.id_doctor}, Cliente ID ${h.id_cliente}, Cita ID ${h.id_cita}, Fecha: ${h.fecha}, Nota: ${h.nota}.`,
            metadata: { tipo: 'historial', id: h.id }
        });
    });

    // Recetas
    recetas.forEach(r => {
        documentos.push({
            pageContent: `Receta ID ${r.id} asociada a la cita ID ${r.id_cita}: ${r.receta}.`,
            metadata: { tipo: 'receta', id: r.id }
        });
    });

    // Usuarios (médicos, secretarios, admin)
    users.forEach(u => {
        documentos.push({
            pageContent: `${u.rol === 'doctor' ? 'Doctor' : 'Usuario'}: ${u.name}, Rol: ${u.rol}, Email: ${u.email}.`,
            metadata: { tipo: u.rol, id: u.id }
        });
    });


    // Separar los textos en fragmentos
    const splitter = new RecursiveCharacterTextSplitter({ chunkSize: 1000, chunkOverlap: 200 });
    const splitDocs = await splitter.splitDocuments(documentos);

    // Generar embeddings y guardar
    const embeddings = new GoogleGenerativeAIEmbeddings({
        apiKey: process.env.GOOGLE_API_KEY,
        modelName: "embedding-001"
    });

    await Chroma.fromDocuments(splitDocs, embeddings, {
        collectionName: 'coleccion_clinica_dental',
        persist_directory: "./chroma_db_data"
    });

    console.log("Datos ingeridos exitosamente en ChromaDB.");
}

ingestData().catch(console.error);
