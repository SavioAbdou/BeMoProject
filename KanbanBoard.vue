<template>
  <div class="kanban-board">
    <div class="kanban-board-header">
      <button class="add-column-button" v-b-modal.add-column-modal>Add Column</button>
    </div>
    <!-- Other Kanban board template elements -->
  </div>
</template>

<template>
    <div>
      <div v-for="column in columns" :key="column.id">
        <h2>{{ column.title }}</h2>
        <button @click="deleteColumn(column.id)">Delete Column</button>
        <button @click="addCard(column.id)">Add Card</button>
        <draggable v-model="column.cards">
          <card v-for="card in column.cards" :key="card.id" :card="card" @edit="editCard" @delete="deleteCard"/>
        </draggable>
      </div>
      <button @click="addColumn">Add Column</button>
    </div>
  </template>
  
  <script>
  import Card from './Card'
  import axios from 'axios'
  import { Draggable } from 'vuedraggable'
  
  export default {
    components: {
      Card,
      Draggable
    },
    data() {
      return {
        columns: [
          // list of columns
        ]
      }
    },
    methods: {
      async addColumn() {
        try {
          const response = await axios.post('/api/columns')
          this.columns.push(response.data)
        } catch (error) {
          console.error(error)
        }
      },
      async deleteColumn(columnId) {
        try {
          await axios.delete(`/api/columns/${columnId}`)
          this.columns = this.columns.filter(column => column.id !== columnId)
        } catch (error) {
          console.error(error)
        }
      },
      async addCard(columnId) {
        try {
          const response = await axios.post(`/api/cards`, { columnId })
          const column = this.columns.find(column => column.id === columnId)
          column.cards.push(response.data)
        } catch (error) {
          console.error(error)
        }
      },
      async editCard(card) {
        try {
          await axios.patch(`/api/cards/${card.id}`, card)
        } catch (error) {
          console.error(error)
        }
      },
      async deleteCard(cardId) {
        try {
          await axios.delete(`/api/cards/${cardId}`)
          this.columns = this.columns.map(column => {
            column.cards = column.cards.filter(card => card.id !== cardId)
            return column
          })
        } catch (error) {
          console.error(error)
        }
     
        <template>
  <div class="kanban-board">
    <template v-for="column in columns">
      <Column :column="column" />
    </template>
  </div>
</template>
<style>
.kanban-board {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
</style>