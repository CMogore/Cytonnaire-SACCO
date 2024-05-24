<template>
    <div>
      <h2 class="text-xl font-semibold mb-4">View and Download Contributions Report</h2>
      <div class="flex">
      <div class="mb-4">
        <label for="start_date" class="mr-2">Start Date:</label>
        <input type="date" v-model="startDate" id="start_date" name="start_date" class="border rounded-md p-1">
      </div>
      <div class="mb-4 ml-6">
        <label for="end_date" class="mr-2">End Date:</label>
        <input type="date" v-model="endDate" id="end_date" name="end_date" class="border rounded-md p-1">
      </div>
      <div class="mb-4 ml-6">
        <button @click="fetchContributions" class="px-4 py-2 bg-blue-500 text-white rounded-md">Fetch Contributions</button>
      </div>
    </div>
      <div v-if="contributions.length > 0">
        <h3 class="text-lg font-semibold mb-2">Contributions Between {{ startDate }} and {{ endDate }}</h3>
        <div class=" text-right">
        <button @click="downloadPDF" class="px-4 py-2 bg-green-500 text-white rounded-md ">Download PDF</button>
        </div>
        <table class="min-w-full" id="contributions-table">
          <thead>
            <tr>
              <th class="px-4 py-2">Amount</th>
              <th class="px-4 py-2">Contribution Date</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="contribution in contributions" :key="contribution.id">
              <td class="border px-4 py-2">{{ contribution.amount }}</td>
              <td class="border px-4 py-2">{{ contribution.contribution_date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else-if="contributionsLoaded">
        <p>No contributions found between the selected dates.</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
  
  export default {
    data() {
      return {
        startDate: '',
        endDate: '',
        contributions: [],
        contributionsLoaded: false
      };
    },
    methods: {
      async fetchContributions() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/getcontributionbetweendates', {
            params: {
              start_date: this.startDate,
              end_date: this.endDate
            },
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.contributions = response.data;
          this.contributionsLoaded = true;
        } catch (error) {
          console.error('Error fetching contributions:', error);
        }
      },
      async downloadPDF() {
        // Convert HTML table to canvas
        const pdf = new jsPDF();
      const table = document.getElementById('contributions-table');
      const canvas = await html2canvas(table);

      // Add heading 
      pdf.setFontSize(18);
      pdf.text(`Contributions Report between ${this.startDate} and ${this.endDate}`, 10, 10);

      // Add the table image
      const imgData = canvas.toDataURL('image/png');
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
      pdf.addImage(imgData, 'PNG', 10, 20, pdfWidth - 20, pdfHeight);

      pdf.save('contributions_report.pdf');

      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles here */
  </style>
  