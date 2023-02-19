<template>
    <div class="addItemContainer">
        <input type="text" class="inputForm" aria-label="input Item" aria-describedby="input Item" placeholder="Type your todo item" v-model="item.title">
        <input type="text" class="inputForm" aria-label="input Item" aria-describedby="input Item" placeholder="Type your todo item" v-model="item.desc">
        <font-awesome-icon icon="plus-square" :class="[item.title ? 'active' : 'inactive', 'plus']" @click="addItem()" />
    </div>

</template>

<script>
import { mapGetters } from "vuex";
export default {
    data: function () {
        return {
            item: {
                title: "",
                desc:""
            }
        }
    },
    methods:{
        addItem() {
            if(this.item.title === ''){
                return;
            }

            axios.post('api/list', {
                item: this.item
            }).then(response => {
                if(response.status == 201){
                    this.item.name = "";
                    this.$emit('reloadList');
                }
            }).catch(error => {
                console.log(error);
            })
        }
    },
    computed: {
      ...mapGetters(["newTodo"])
    }
}
</script>

<style scoped>
.addItemContainer{
    display: flex;
}
.inputForm{
    min-width: 100%;
    height: 2rem;
    border: none;
    border-bottom: 1px solid #ccc;
    outline: none;
    color: #5C5D67;
}

.plus{
    font-size: 2rem;
    margin-left: 1rem;
    cursor: pointer;
}
.active{
    color: #3E885B;
}

.inactive{
    color: #5C5D67;
}
</style>
