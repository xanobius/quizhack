<template>
    <div>
        <div v-if=" ! login">
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
                <input type="submit" value="">
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "ModeratorView",
    data() {
        return {
            loginFrm : {
                email : '',
                password : ''
            },
            login : false
        }
    },
    created () {
        console.log('loaded')
    }
}
</script>

<style scoped>

</style>
