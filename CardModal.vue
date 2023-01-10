<template>
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h2>{{ card.title }}</h2>
        <textarea v-model="card.description"></textarea>
        <button @click="closeModal">Close</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      card: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        isModalOpen: true
      }
    },
    methods: {
      closeModal() {
        this.isModalOpen = false
        this.$emit('edit', this.card)
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
    <b-modal ref="cardModal" id="card-modal" title="Card Details">
      <template v-slot:modal-body>
        <b-form-group label="Title" label-for="title-input">
          <b-form-input id="title-input" v-model="card.title" type="text" required></b-form-input>
        </b-form-group>
        <b-form-group label="Description" label-for="description-input">
          <b-form-input id="description-input" v-model="card.description" type="text"></b-form-input>
        </b-form-group>
      </template>
      <template v-slot:modal-footer>
        <b-button variant="secondary" @click="$refs.cardModal.hide()">Close</b-button>
        <b-button variant="primary" @click="updateCard">Save Changes</b-button>
      </template>
    </b-modal>
  </template>
  
  <script>
  export default {
    props: ['card'],
    methods: {
      updateCard() {
        // Send an update request to the server to update the card in the database
        // Then close the modal
        this.$refs.cardModal.hide()
      }
    }
  }
  </script>
  <template>
    <!-- Card modal template -->
    <b-modal ref="modal" id="card-modal" title="Edit Card">
      <b-form @submit.prevent="updateCard" class="card-modal-form">
        <b-form-group label="Title" label-for="title-input">
          <b-form-input id="title-input" v-model="card.title" type="text" required></b-form-input>
        </b-form-group>
        <b-form-group label="Description" label-for="description-input">
          <b-form-input id="description-input" v-model="card.description" type="text" required></b-form-input>
        </b-form-group>
        <b-button type="submit" variant="primary">Save</b-button>
        <b-button @click="closeModal" variant="secondary">Cancel</b-button>
      </b-form>
    </b-modal>
  </template>
  
  <script>
  export default {
    props: ['card'],
    methods: {
      updateCard() {
        // Make a PUT request to update the card
        axios.put('/api/cards/' + this.card.id, this.card)
          .then(response => {
            // Close the modal and emit the updated card
            this.$refs.modal.hide();
            this.$emit('card-updated', response.data.card);
          })
          .catch(error => {
            console.log(error);
          });
      },
      closeModal() {
        // Close the modal
        this.$refs.modal.hide();
      }
    }
  }
  </script>
  <template>
    <b-modal ref="cardModal" title="Edit Card" v-if="card">
      <b-form-group label="Title" label-for="title-input">
        <b-form-input id="title-input" v-model="card.title" type="text" required></b-form-input>
      </b-form-group>
      <b-form-group label="Description" label-for="description-input">
        <b-form-input id="description-input" v-model="card.description" type="text" required></b-form-input>
      </b-form-group>
      <template v-slot:modal-footer>
        <b-button variant="secondary" @click="closeModal">Close</b-button>
        <b-button variant="primary" @click="updateCard">Save</b-button>
      </template>
    </b-modal>
  </template>
  <script>
  import axios from 'axios';
  
  export default {
    name: 'CardModal',
    props: ['card'],
    methods: {
      closeModal() {
        this.$refs.cardModal.hide();
      },
      updateCard() {
        axios.patch(`/api/cards/${this.card.id}`, this.card).then(response => {
          this.closeModal();
        });
      }
    }
  };
  </script>