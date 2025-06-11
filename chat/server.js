require('dotenv').config();
console.log("API KEY:", process.env.GOOGLE_API_KEY);


const express = require('express');
const cors = require('cors');
const { GoogleGenerativeAIEmbeddings, ChatGoogleGenerativeAI } = require('@langchain/google-genai');
const { Chroma } = require('@langchain/community/vectorstores/chroma');
const { RetrievalQAChain } = require('langchain/chains');
const { PromptTemplate } = require('@langchain/core/prompts');

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(express.json());

let chain; // La cadena de LangChain para la IA

async function initializeChain() {
    try {
        // 1. Inicializar embeddings (DEBE SER EL MISMO QUE USAMOS EN `ingest.js`)
        const embeddings = new GoogleGenerativeAIEmbeddings({
            apiKey: process.env.GOOGLE_API_KEY,
            modelName: "embedding-001"
        });

        // 2. Cargar la base de datos vectorial de ChromaDB (desde el modo persistente local)
        const vectorStore = await Chroma.fromExistingCollection(embeddings, {
            collectionName: 'coleccion_clinica_dental',
            persist_directory: "./chroma_db_data", // Debe ser la misma ruta que en ingest.js
        });
        console.log('ChromaDB cargado exitosamente.');

        // 3. Inicializar el modelo de lenguaje (LLM) de Google Gemini
        /*const llm = new ChatGoogleGenerativeAI({
            apiKey: process.env.GOOGLE_API_KEY,
            //modelName: "gemini-pro", // Puedes usar "gemini-pro" o "gemini-1.5-flash"
            temperature: 0.7 // Controla la creatividad de la respuesta (0.0 a 1.0)
        }); */

        const llm = new ChatGoogleGenerativeAI({
            apiKey: process.env.GOOGLE_API_KEY,
            temperature: 0.7,
    //            model: "gemini-pro" // en vez de modelName, algunas versiones usan 'model'
            model: "gemini-1.5-flash"
    
        });


        // 4. Crear el retriever para buscar en la base de datos vectorial
        const retriever = vectorStore.asRetriever();

        // 5. Definir un prompt personalizado (¡Muy importante para la calidad de la respuesta!)
        const customPromptTemplate = `
        Eres un asistente útil que responde preguntas sobre productos.
        Usa la siguiente información de contexto para responder la pregunta.
        Si la pregunta no está relacionada con la información de los productos, no respondas sobre ese tema o di que no tienes información.
        Sé conciso y directo en tus respuestas.

        Contexto:
        {context}

        Pregunta: {question}

        Respuesta:
        `;
        const customPrompt = PromptTemplate.fromTemplate(customPromptTemplate);

        // 6. Crear la cadena de recuperación y pregunta/respuesta (RetrievalQAChain)
        chain = RetrievalQAChain.fromLLM(llm, retriever, {
            prompt: customPrompt,
            returnSourceDocuments: true, // Útil para depuración: muestra qué documentos se usaron
        });

        console.log('Cadena de IA inicializada y lista.');

    } catch (error) {
        console.error('Error al inicializar la cadena de IA:', error);
        console.error('Asegúrate de que tu clave API de Google sea correcta y que ingest.js se haya ejecutado.');
        process.exit(1); // Salir si no se puede inicializar la IA
    }
}

// Inicializar la cadena cuando el servidor se inicie
initializeChain();

// Ruta para manejar las preguntas del chat
app.post('/chat', async (req, res) => {
    const { question } = req.body;

    if (!question) {
        return res.status(400).json({ error: 'La pregunta es requerida.' });
    }

    if (!chain) {
        return res.status(500).json({ error: 'La IA no está inicializada. Por favor, inténtalo de nuevo más tarde.' });
    }

    try {
        console.log(`Pregunta recibida: "${question}"`);
        const result = await chain.call({ query: question });

        console.log('Respuesta de la IA:', result.text);
        // console.log('Documentos fuente:', result.sourceDocuments.map(doc => doc.metadata.nombre)); // Para depuración

        res.json({ answer: result.text });
    } catch (error) {
        console.error('Error al procesar la pregunta:', error);
        res.status(500).json({ error: 'Hubo un error al procesar tu pregunta.' });
    }
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor backend corriendo en http://localhost:${port}`);
});