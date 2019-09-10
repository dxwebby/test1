const state = {
    todos: [],
}

const getters = {
    todos: (state) => state.todos,
}

const actions = {
    getTodos({commit}){        
        let request = axios.get(`/vtodo`).then(response =>{
            console.log(response.data);
            // console.log(response.data.todos)
            commit('FETCH_TODOS', response.data.todos);
        })
    },
    addTodo({commit}, todo){
        return new Promise((resolve, reject) =>{
            let request = axios.post(`/vtodo`, todo).then(response =>{
                
                // Validated data
                if(response.data.success){                                        
                    commit('ADD_TODO', response.data.todo);                    
                }    

                // Result
                resolve(response.data)                    

            }).catch(err =>{                
                reject(err)
            })
        })       
    },
}

const mutations = {
    FETCH_TODOS: (state, todos) => (state.todos = todos),
    ADD_TODO: (state, todo) => state.todos.push(todo),
}

export default{
    state,
    getters,
    actions,
    mutations,
}