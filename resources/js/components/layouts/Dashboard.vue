<template>
    <div class="container">
        <div>
            <h2>Todo List</h2>
        </div>
        <add-item v-on:reloadList="getAllItems()" />
        <list-items :items="items" v-on:reloadList="getAllItems()" />
    </div>



</template>

<script>
import addItem from "./addItem";
import listItems from "./listItems";

export default {
    components: {
        addItem,
        listItems
    },
    data: function(){
        return{
            items: []
        }
    },
    mounted() {

          window.Echo.channel("newTask").listen(".task-created", e => {
              this.$store.commit("ADD_TODO", e.task);
              this.newTodo.title = "";
          });

          window.Echo.channel("taskRemoved").listen(".task-removed", e => {
              this.$store.commit("DELETE_TODO", this.toRemove);
          });

          window.Echo.channel("editTask").listen(".task-updated", e => {
              this.$store.commit("UPDATE_TODO", this.updated);
          });
      },
      computed: {
          ...mapGetters(["newTodo", "toRemove","updated"])
      },
    methods: {
        getAllItems(){
            axios.get('api/list').then(response => {
                this.items = response.data;
            }).catch(error => {
                console.log(error);
            })
        }
    },
    created(){
        this.getAllItems();
    }
}
</script>

<style scoped>
    .container{
        display: flex;
        width: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fafafc;
    }

    h2{
        font-size: 2rem;
    }
</style>
