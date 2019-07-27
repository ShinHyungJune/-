<template>
    <div id="login">
        <div class="wrap-300">
            <img src="/img/logo.png" alt="" class="logo">

            <form action="" @submit.prevent="login" @keydown="form.errors.clear()">

                <div class="input input-text">
                    <input type="text" placeholder="이메일 아이디" v-model="form.email">
                    <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
                </div>

                <div class="input input-text">
                    <input type="password" placeholder="비밀번호" v-model="form.password">
                    <p class="error" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></p>
                    <p class="error" v-if="form.errors.has('invalid')" v-text="form.errors.get('invalid')"></p>
                </div>

                <div class="utils">
                    <router-link to="/passwordReset" class="util">비밀번호 찾기</router-link>
                    <span class="hyphen">/</span>
                    <router-link to="/register" class="util">회원가입</router-link>
                </div>

                <button class="btn-login btn-full btn-text bg-primary">로그인</button>
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
                    password: ""
                })
            }
        },

        methods: {
            login() {
                this.form.post("/api/auth/login")
                    .then((response) => {
                        this.$store.commit("SET_USER", response.data.user);

                        this.$store.commit("SET_TOKEN", response.data.token);

                        if (this.$store.state.intendedUrl && this.$store.state.isBlockedRoute) {
                            this.$router.push(this.$store.state.intendedUrl);
                            this.$store.commit("SET_INTENDED_URL", null);
                        }else{
                            this.$router.push('/');
                        }
                    })
                    .catch((error) => {
                        // validation 에러가 아닌, invalid 등의 에러
                        if(!error.errors)
                            this.form.errors.record({invalid: [error.message]});
                    });
            }
        }
    }
</script>
