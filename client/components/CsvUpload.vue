  
  <script setup>
  import { ref } from "vue";
  import { useFetch } from "#app";
  
  const csvFile = ref(null);
  const message = ref("");
  
  const handleFileUpload = (event) => {
    csvFile.value = event.target.files[0];
  };
  
  const uploadCsv = async () => {
    if (!csvFile.value) return;
  
    let formData = new FormData();
    formData.append("csv_file", csvFile.value);
    
    try {
      const { data, error } = await useFetch("http://localhost:8000/api/import-users", {
        method: "POST",
        body: formData,
      });
  
      if (error.value) throw error.value;
  
      message.value = data.value.message;
    } catch (err) {
      console.error("Upload failed", err);
      message.value = "Upload failed. Check the file format.";
    }
  };
</script>

<template>
    <div>
      <input type="file" @change="handleFileUpload" accept=".csv" />
      <button @click="uploadCsv" :disabled="!csvFile">Upload CSV</button>
  
      <p v-if="message">{{ message }}</p>
    </div>
</template>

  