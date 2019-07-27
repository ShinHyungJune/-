<template>
    <div id="register">
        <div class="wrap-300">
            <img src="/img/logo.png" alt="" class="logo">
            <form action="" @submit.prevent="sendNumber" class="sendNumber" @keydown="form.errors.clear()"  v-if="mode === 'sendNumber'">
                <div class="input input-text">
                    <input type="text" placeholder="사용할 이메일을 입력해주세요." v-model="form.email">
                </div>

                <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>

                <button class="btn-text btn-full bg-primary" v-if="!loading">인증메일 보내기</button>
                <button class="btn-text btn-full bg-primary animated infinite flash" v-else>메일 전송중</button>
            </form>

            <form action="" @submit.prevent="checkNumber" class="checkNumber" @keydown="form.errors.clear()"  v-if="mode === 'checkNumber'">
                <div class="input input-text">
                    <input type="text" placeholder="인증번호를 입력해주세요." v-model="form.number">
                </div>
                <p class="error" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></p>

                <button class="btn-text btn-full bg-primary" v-if="!loading">인증하기</button>
                <button class="btn-text btn-full bg-primary animated infinite flash" v-else>인증 진행중</button>
            </form>

            <form action="" @submit.prevent="register" @keydown="form.errors.clear()"  v-if="mode === 'register'">
                <div class="input-img">
                    <label for="image">
                        <div class="box_img"  v-if="form.avatar">
                            <img :src="form.avatar" alt="">
                        </div>

                        <img src="/img/img_camera.png" alt="" v-else>

                    </label>

                    <input type="file" id="image" @change="getImage">

                    <p class="error" v-if="form.errors.has('avatar')" v-text="form.errors.get('avatar')"></p>
                </div>

                <div class="input input-text">
                    <input type="text" placeholder="닉네임 또는 이름" v-model="form.name">
                    <p class="error" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></p>
                </div>

                <div class="input input-text">
                    <input type="text" placeholder="이메일 아이디" v-model="form.email" disabled class="bg-primary white">
                    <p class="error" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
                </div>

                <div class="input input-text">
                    <input type="text" placeholder="보조 이메일" v-model="form.email_sub">
                    <p class="error" v-if="form.errors.has('email_sub')" v-text="form.errors.get('email_sub')"></p>
                    <p class="notice accent">이메일 아이디 분실 시 이용될 이메일입니다.</p>
                </div>

                <div class="input input-text">
                    <input type="password" placeholder="비밀번호" v-model="form.password">
                </div>

                <div class="input input-text">
                    <input type="password" placeholder="비밀번호 확인" v-model="form.password_confirmation">
                    <p class="error" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></p>
                </div>

                <button class="btn-text btn-full bg-primary" v-if="!loading">회원가입</button>
                <button class="btn-text btn-full bg-primary animated infinite flash" v-else>진행중</button>
            </form>
        </div>
    </div>
</template>
<script>

    export default {
        data(){
            return {
                form: new Form({
                    avatar: '',
                    email: "",
                    email_sub: "",
                    password: "",
                    password_confirmation: "",
                    name: "",
                    department: "",
                    position: "",
                    contact: "",
                    number: "",
                }),
                loading: false,
                email: "",
                verifyNumber: null,
                mode: "sendNumber"
            }

        },

        methods: {
            getImage(e){
                let image = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(image);

                reader.onload = e => {
                    this.form.avatar = e.target.result;
                }
            },

            sendNumber(){
                this.email = this.form.email;

                this.loading = true;

                this.form.post('/api/verifyNumbers')
                    .then((response) => {
                        this.$store.commit("SET_FLASH", {activated : true, message : response.message});

                        this.verifyNumber = response.data;

                        this.mode = "checkNumber"
                    })
                    .catch((error) => {
                        if(!error.errors)
                            this.$store.commit("SET_FLASH", {activated : true, message : error.error.message, type: "check"});
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },

            checkNumber(){
                this.loading = true;

                this.form.patch('/api/verifyNumbers/' + this.verifyNumber.id)
                    .then((response) => {

                        this.$store.commit("SET_FLASH", {activated : true, message : response.message});

                        this.mode = "register";

                        this.form.email = this.email;
                    })
                    .catch((error) => {
                        if(!error.errors)
                            this.$store.commit("SET_FLASH", {activated : true, message : error.error.message, type: "check"});
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },

            register(){
                this.loading = true;

                this.form.email = this.email;

                this.form.post('/api/auth/signup')
                    .then((response) => {
                        this.$store.commit("SET_FLASH", {activated : true, message : response.message, type:"check"});

                        this.$router.push('/login');
                    })
                    .catch((error) => {
                        if(!error.errors)
                            this.$store.commit("SET_FLASH", {activated : true, message : error.error.message, type: "check"});
                    })
                    .then(() => {
                        this.loading = false;
                    })
            },


        }
    }
</script>
