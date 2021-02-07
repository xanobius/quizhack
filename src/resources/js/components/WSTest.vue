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
        <ul>
            <li v-for="q in questions">{{ q }}</li>
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
            questions : [],
            answers: []
        }
    },
    created() {
        window.Echo.channel('quiz.questions')
            .listen('NewQuestion', (e) => {
                this.questions.push(e.question)
                console.log(e);
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
        sendText() {
            this.connection.send(this.message);
        }
    },
}
</script>

<style scoped>

</style>
