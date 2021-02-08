<template>
    <div>
        <h1>hello</h1>
        <div class="col-6">
            <div class="form-group">
                <input type="text" class="form-control" v-model="message">
            </div>
        </div>
        <button class="btn-success btn" @click="connect">
            Connect
        </button>

        <div v-if="currentQuestion != null">
            Question : {{ currentQuestion.question }} <br>
            <form @submit.prevent="giveAnswer">
                <input v-model="answer" type="text "/>
                <input type="submit" value="antworten">
            </form>
        </div>
        <ul>
            <li v-for="q in questions">{{ q.question }}</li>
        </ul>
        <ul>
            <li v-for="a in answers">{{ a }}</li>
        </ul>

        <div class="col-1">
            <button class="btn btn-success" :disabled=" ! connected" @click="sendText">Send</button>
        </div>
    </div>
</template>

<script>

export default {
    components : {
        'Echo' : Echo
    },
    name: "WSTest.vue",
    data () {
        return {
            message: '',
            connection: null,
            connected : false,
            currentQuestion : null,
            answer: '',
            questions : [],
            answers: []
        }
    },
    created() {
        window.Echo.channel('quiz.questions')
            .listen('NewQuestion', (e) => {
                this.currentQuestion = e.question
                this.questions.push(e.question)
                console.log(e);
            })
        window.Echo.channel('quiz.answers')
            .listen('NewAnswer', (e) => {
                this.answers.push(e.data)
            })
    },
    methods: {
        connect() {
            this.connection = new WebSocket("ws://websockets.test:6001/tryout");

            this.connection.onmessage = event => {
                console.log(event.data);
            }

            this.connection.onopen = event => {
                console.log(event);
                this.connected = true;
            }

            this.connection.onclose = event => {
                this.connected = false;
            }

        },
        sendText()
        {
            this.connection.send(this.message);
        },
        giveAnswer()
        {
            axios.post('question/answer/' + this.currentQuestion.id, { answer : this.answer})
                .then(e => {
                    console.log(e)
                })
            .catch(e => {
                console.log('ERROR')
            })
        }
    },
}
</script>

<style scoped>

</style>
