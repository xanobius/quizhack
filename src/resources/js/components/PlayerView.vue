<template>
    <div>
        <div v-if=" ! joined">
            <label>
                Nickname
                <input type="text" name="nick" v-model="nick">
            </label>
            <button @click="login">Beitreten</button>
        </div>

        <div v-if="joined">
            Yay, logged in as {{ nick }}
        </div>
    </div>
</template>

<script>
export default {
    name: "PlayerView",

    data() {
        return {
            joined : false,
            nick : '',
            players: [],
            /*
            [
                { nick: 'Alex', score: '20'},
                { nick: 'Kevin', score: '23'},
            ]
             */
            question: {},
            /*
                { question: 'Who the fuck is alice', id: 1243}
             */
            answer: ''
        }
    },
    created() {
        console.log('dini mama');
        this.connect();
    },
    methods : {
        connect() {
            this.connection = new WebSocket('ws://websockets.test:6001/player');
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

        // Method to login
        login() {
            // Send nick to backend and create player

            this.joined = true
        }
        // Method to answer question
    }
}
</script>

<style scoped>

</style>
