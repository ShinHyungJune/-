<template>
    <div class="wrap-300">
        <div id="sendResetPasswordMail">
            <img src="/img/logo.png" alt="" class="logo">

            <form action="" @submit.prevent="submit" @keydown="form.errors.clear()">
                <div class="input input-text">
                    <input type="text" placeholder="이메일 아이디를 입력하세요." v-model="form.email">
                    <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
                </div>

                <button class="btn-text btn-full bg-primary" v-if="!loading">비밀번호 재설정메일 보내기</button>
                <button class="btn-text btn-full bg-primary animated flash infinite" v-else>메일 전송중</button>
            </form>

        </div>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                form: new Form({
                    email: ""
                }),

                loading: false
            }
        },

        methods: {
            submit() {
                this.loading = true;

                this.form.post("/api/passwordReset/send")
                    .then((response) => {
                        this.$store.commit("SET_FLASH", {activated: true, type:"check", message: response.message});

                        this.$router.push('/login');
                    })
                    .catch((error) => {
                        console.log(error);
                        if(!error.errors)
                            this.$store.commit("SET_FLASH", {activated: true, type:"check", message: error.error.message})
                    })
                    .then(() => {
                        this.loading = false;
                    })
            },

        }
    }
</script>
