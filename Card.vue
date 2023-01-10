<template>
    <div>
      <div v-if="isModalOpen" class="modal-overlay">
        <div class="modal-content">
          <h2>{{ card.title }}</h2>
          <textarea v-model="card.description"></textarea>
          <button @click="closeModal">Close</button>
        </div>
      </div>
      <div @click="openModal">
        {{ card.title }}
      </div>
      <button @click="deleteCard">Delete</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    props: {
      card: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        isModalOpen: false
      }
    },
    methods: {
      openModal() {
        this.isModalOpen = true
      },
      closeModal() {
        this.isModalOpen = false
        this.$emit('edit', this.card)
      },
      async deleteCard() {
        try {
          await axios.delete(`/api/cards/${this.card.id}`)
          this.$emit('delete', this.card.id)
        } catch (error) {
          console.error(error)
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }
  
  .modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 1rem;
    border-radius: 0.5rem;
  }
  </style>
  <template>
    <div class="card" ref="card">
      <!-- Card content goes here -->
    </div>
  </template>
  
  <script>
  import draggable from 'vue-draggable';
  
  export default {
    name: 'Card',
    props: ['card'],
    components: {
      draggable
    },
    mounted() {
      this.$refs.card.addEventListener('dragstart', this.handleDragStart);
      this.$refs.card.addEventListener('dragend', this.handleDragEnd);
    },
    beforeDestroy() {
      this.$refs.card.removeEventListener('dragstart', this.handleDragStart);
      this.$refs.card.removeEventListener('dragend', this.handleDragEnd);
    },
    methods: {
      handleDragStart(e) {
        e.dataTransfer.setData('cardId', this.card.id);
      },
      handleDragEnd() {
        // Update the card's column_id in the database using an API call or a Vuex action
      }
    }
  };
  </script>
  