/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('todo', require('./components/todo.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

///////////////////////////////////////////////////////////////

$(document).ready(function(){  
    // AJAX    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Focus
    $("input[name=new_title]").focus();

    // Data
    let id = $("input[name=id]").val();        
    
    // Update Title
    $('#update_title').on('submit', function(e){        
        e.preventDefault();                    
        $.ajax({            
            url: '/todo/' + id,  
            method: 'PATCH',
            data: {
                new_title: $("input[name=new_title]").val()               
            },
            success: function(result){
                // Remove errors
                $("#ajax-errors").text('');
                $(".error-container").css({
                    'display': 'none'
                });     
               
                if(result.success){
                    // alert('success')
                    $(".current_title").text(result.new_title);
                }else{
                    // alert('failed')
                    // Clear errors
                    
                    let e = result.data;                                        
                    if(typeof e.new_title !== "undefined"){   
                        $(".error-container").css({
                            'display': 'block'
                        });                        
                        $("#ajax-errors").append('Title is required.')                                                
                    }

                    $("input[name=new_title]").focus();

                }
            }});         
    })

    // Delete Title
    $("#delete_title").on("click", function(e){
        e.preventDefault();
        $.ajax({
            url: '/todo/' + id,
            method: 'DELETE',
            success:function(result){                
                if(result.success){
                    window.location.replace('/todo')
                }else{
                    console.log("Something went wrong on the server.");
                }
            }
        });
    })
})