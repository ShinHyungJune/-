<template>
    <div class="wrap-300">
        <div id="resetPassword">
            <img src="/img/logo.png" alt="" class="logo">

            <form action="" @submit.prevent="submit" @keydown="form.errors.clear()">
                <div class="input input-text">
                    <input type="text" placeholder="이메일 아이디" v-model="form.email">
                    <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
                </div>

                <div class="input input-text">
                    <input type="password" placeholder="비밀번호" v-model="form.password">
                </div>

                <div class="input input-text">
                    <input type="password" placeholder="비밀번호 확인" v-model="form.password_confirmation">
                    <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('password')"></p>
                </div>

                <button class="btn-text btn-full bg-primary">비밀번호 재설정하기</button>
            </form>

        </div>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                form: new Form({
                    email: "",
                    password: "",
                    password_confirmation: "",
                    token: null
                }),
            }
        },

        computed: {
            token(){
                return this.$route.params.token;
            }
        },

        methods: {
            submit() {
                this.form.token = this.token;

                this.form.post("/api/passwordReset")
                    .then((response) => {
                        this.$store.commit("SET_FLASH", {activated: true, type:"check", message: response.message});

                        this.$router.push('/login');
                    })
                    .catch((error) => {
                        if(!error.errors)
                            this.$store.commit("SET_FLASH", {activated: true, type:"check", message: error.error.message})
                    });
            },

        }
    }
</script>
