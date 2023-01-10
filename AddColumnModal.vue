
<template>
    <modal name="add-column-modal" height="auto" :scrollable="true">
      <form @submit.prevent="addColumn" class="add-column-form">
        <label for="title">Column Title</label>
        <input type="text" v-model="title" id="title" required />
        <button type="submit" class="add-column-button">Add Column</button>
      </form>
    </modal>
  </template>

  
  <script>
  import { Modal } from 'bootstrap-vue/esm';
  
  export default {
    name: 'AddColumnModal',
    components: {
      Modal
    },
    data() {
      return {
        title: ''
      }
    },
    methods: {
      addColumn() {
        // Add column logic goes here
        this.title = '';
        this.$bvModal.hide('add-column-modal');
      }
    }
  };
  </script>
  