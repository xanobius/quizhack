<template>
    <div>
        <div v-if="status.show" :class="status.type">
            <span>{{ status.message }}</span>
        </div>

        <div v-if=" ! loggedIn">
            <div>
                <label for="email">
                    Email
                    <input type="text" name="email" id="email" v-model="loginFrm.email">
                </label>
            </div>
            <div>
                <label for="password">
                    Password
                    <input type="password" name="password" id="password" v-model="loginFrm.password">
                </label>
            </div>
            <div>
                <input type="submit" value="login" @click="doLogin">
            </div>
            <div>
                <input type="button" value="check login" @click="checkLogin">
            </div>
        </div>

        <div v-if="loggedIn">
            <div v-if=" ! activeQuestion">
                <form action="#" @submit.prevent="askQuestion">
                    <div>
                        <input type="text" placeholder="next question: " v-model="questionFrm.question">
                        <input type="submit" value="ask question">
                    </div>
                </form>
            </div>
            <div v-if="activeQuestion">
                Current Question : <span>{{ activeQuestion.question }}</span>
                <ul>
                    <li v-for="a in answers">{{ a }} <span>Correct</span> <span>Wrong</span> </li>
                </ul>

            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "ModeratorView",
    data() {
        return {
            connection: null,
            status : {
                show: false,
                type: '',
                message: ''
            },

            loginFrm : {
                email : '',
                password : ''
            },
            questionFrm : {
                question : ''
            },
            loggedIn : false,
            activeQuestion : null,
            answers : []
        }
    },
    created () {
        this.connect()
    },
    methods : {
        connect() {
            this.connection = new WebSocket('ws://websockets.test:6001/moderator');
            this.connection.onmessage = event => {
                let parsed = JSON.parse(event.data);
                if( parsed ){
                    this.parseResponse(parsed)
                }else{
                    console.log(event.data);
                }
            }

            this.connection.onopen = event => {
                this.connected = true;
                // Maybe already logged in, directly load main mask
                if(this.connection) this.checkLogin()
            }
            this.connection.onclose = event => {
                this.connected = false;
            }
        },
        parseResponse(data) {
            this.status.show = true;
            if(data.success != true){
                this.status.type = 'alert'
                this.status.message = data.error
            }else{
                this.status.type = 'success'
                this.status.message = data.data.message
            }
            this.loggedIn = data.login_state
        },
        doLogin() {
            let msg = JSON.stringify({
                action : 'login',
                data : {
                    email : this.loginFrm.email,
                    password : this.loginFrm.password
                }
            })
            this.connection.send(msg)
        },
        checkLogin(){
            this.connection.send(JSON.stringify({action: 'checkLogin'}))
        },
        askQuestion(){
            axios.post('question/ask', {'question' : this.questionFrm.question})
                .then(e => {
                    this.activeQuestion = e.data
                    this.questionFrm.question = '';
                })
                .catch(e =>  {
                    console.log(e)
                })
        }
    }
}
</script>

<style scoped>

</style>
