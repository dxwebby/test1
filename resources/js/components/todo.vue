<template>
    <div>        
        <div class="row">
            <div class="col-lg-12">
                <form v-on:submit.prevent>
                    <label for="title">Enter Title</label>
                    <div class="input-group">
                        <input type="text" class="form-control" 
                                v-model="title" ref="title" 
                                v-bind:class="{ 'is-invalid': error.title}"
                                laceholder="New title...">    
                        <div class="invalid-tooltip">This field is required...</div>
                        <div class="input-group-append">
                            <button v-on:click="addTodo" class="btn btn-primary">Add Todo</button>
                        </div>
                    </div>
                    
                </form>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="todo in todos" :key="todo.index">
                                    <th scope="row">{{todo.id}}</th>
                                    <td>{{todo.title}}</td>
                                    <td>
                                        <button class="btn btn-primary mr-2" @click="editTitle(todo.id, todo.title)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>                                    
                                </tr>
                            </tbody>
                        </table>                        
                    </div>
                </div>                
            </div>        
        </div>

        <!-- Modal -->
        <transition name="modal">
            <div v-if="modal.show" class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                <div class="modal-header">
                    <u class="alert alert-primary">{{edit.title | capitalize}}</u>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        <div v-if="modal.type == 'edit'">
                            <div>
                                <label for="title">New Title</label>
                            </div>
                            <div class="input-group mb-2">                            
                                <input type="text" class="form-control" name="edit_title" v-model="edit.title" ref="edit_title">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>                                
                        </div>
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">                    
                    <button class="btn btn-secondary" @click="modal.show = false">
                        Close
                    </button>
                    </slot>
                </div>
                </div>
            </div>
            </div>
        </transition>
        
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';    
    export default {
        data(){
            return{
                title: '',
                edit:{
                    title: '',
                },
                modal:{
                    show: false,                    
                    type: '',
                },                  
                error:{
                    title: false,
                },
            }
        },
        mounted(){   
            this.$refs.title.focus();         
        },  
        filters:{
            capitalize:function(value){
                if(!value) return ''
                    value = value.toString()
                    return value.charAt(0).toUpperCase() + value.slice(1)
                },
        },
        computed:{
            ...mapGetters(['todos']),
        },
        methods:{
            ...mapActions(['getTodos', 'addTodo']),
            task:function(){
                console.log('task')
            },
            addTodo:function(){
                const data = {
                    title: this.title
                }
                this.$store.dispatch('addTodo', data).then(response =>{                                                            
                    if(response.success){
                        // Success
                        this.error.title = false;
                        this.title = "";                        
                    }else{
                        // Fail                        
                        console.log("Fail")
                        this.error.title = true;                        
                    }

                    // Focus on input
                    this.$refs.title.focus();
                })
            },
            editTitle:function(id, title){      
                // Set modal settings
                this.modal.type = "edit";
                this.modal.show = true;

                // Set data
                this.edit.title = title;

                // Focus
                let $this = this;                
                setTimeout(function(){
                    $this.$refs.edit_title.focus();    
                    $("input[name=edit_title]").select();
                }, 300)
                
                console.log(id + " - " + title)
                
            },
        },
        created(){
            this.getTodos();            
        },        
    }
</script>

<style lang="scss" scoped>
thead tr th{    
    font-weight:700;
}   


// Modal VUE
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }
  
  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-header{
      justify-content: center;      
  }

  .alert{
      width: 100%;
      text-align:center;
  }
  
  .modal-container {
    width: 600px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
  }

  .modal-body {
    margin: 20px 0;
  }
 
  /*
   * The following styles are auto-applied to elements with
   * transition="modal" when their visibility is toggled
   * by Vue.js.
   *
   * You can easily play with the modal transition by editing
   * these styles.
   */
  
  .modal-enter {
    opacity: 0;
  }
  
  .modal-leave-active {
    opacity: 0;
  }
  
  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }     

  .btn{
        outline:none;
        border-radius: 2px;
        -webkit-box-shadow: 10px 10px 13px -6px rgba(0,0,0,0.19);
        -moz-box-shadow: 10px 10px 13px -6px rgba(0,0,0,0.19);
        box-shadow: 10px 10px 13px -6px rgba(0,0,0,0.19);
  }
  
</style>