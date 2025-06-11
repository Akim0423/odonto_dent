const { ChromaClient } = require('chromadb');

const client = new ChromaClient({ url: "http://localhost:8000" });

client.heartbeat()
  .then(console.log)
  .catch(console.error);
