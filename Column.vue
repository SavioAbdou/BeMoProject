<template>
  <div class="column">
    <div class="column__header">
      <h2 class="column__title">{{ column.title }}</h2>
      <button class="column__delete-button" @click="deleteColumn">Delete</button>
    </div>
    <div class="column__body">
      <draggable class="card-list" :list="column.cards" :element="'ul'" @change="updateCardPositions">
        <li v-for="card in column.cards" :key="card.id" class="card-list__item">
          <Card :card="card" @openCardModal="openCardModal"/>
        </li>
      </draggable>
      <button class="column__add-card-button" @click="openAddCardModal">Add Card</button>
    </div>
  </div>
</template>

<script>
import Card from './Card.vue';
import { Draggable } from 'vuedraggable';

export default {
  name: 'Column',
  components: {
    Card,
    Draggable
  },
  props: {
    column: {
      type: Object,
      required: true
    }
  },
  methods: {
    deleteColumn() {
      // Delete column logic goes here
    },
    updateCardPositions() {
      // Update card positions logic goes here
    },
    openCardModal(card) {
      // Open card modal logic goes here
    },
    openAddCardModal() {
      // Open add card modal logic goes here
    }
  }
};
</script>

<style lang="scss">
.column {
  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
  }
  &__title {
    margin: 0;
    font-

    <template>
<div class="column">
  <h2 class="column-title">{{ column.title }}</h2>
  <button class="delete-column-button" @click="deleteColumn">Delete Column</button>
  <div class="card-list">
    <template v-for="card in column.cards">
      <Card :card="card" />
      </template>
  </div>


  <form @submit.prevent="addCard" class="add-card-form">
    <b-form-group label="Title" label-for="title-input">
      <b-form-input id="title-input" v-model="cardTitle" type="text" required></b-form-input>
    </b-form-group>
    <b-form-group label="Description" label-for="description-input">
      <b-form-input id="description-input" v-model="cardDescription" type="text" required></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Add Card</b-button>
  </form>
</div>
</template>

<template>
<div class="column">
  <!-- Column content goes here -->
  <draggable v-model="column.cards" :options="{ group: 'kanban-board', handle: '.card-handle' }">
    <template v-for="card in column.cards">
      <Card :card="card" class="card-handle" />
    </template>
  </draggable>
</div>
</template>


<script>
export default {
name: 'Column',
props: ['column'],
components: {
  Card
}
};
</script>