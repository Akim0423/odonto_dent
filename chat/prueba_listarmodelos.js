require('dotenv').config();
const { GenerativeLanguageClient } = require('@google/generative-ai');

async function listModels() {
  const client = new GenerativeLanguageClient({
    apiKey: process.env.GOOGLE_API_KEY,
  });

  try {
    const response = await client.listModels();
    console.log('Modelos disponibles:');
    response.models.forEach(model => {
      console.log(`- ${model.name}`);
    });
  } catch (error) {
    console.error('Error al listar modelos:', error);
  }
}

listModels();
