<template>
    <div :class="flashClass" :id="type">
        <div class="flash-content bg-accent">
            <p class="flash-text">
                {{message}}
            </p>
            <button type="text" class="flash-button" v-if="type === 'check'" @click="close">
                확인
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        watch: {
            type(){
                return this.$store.state.flash.type;
            }
        },

        data(){
            return {
                flashClass: "flash-box animated fadeIn faster"
            }
        },

        mounted(){
            let self = this;

            if(this.type !== "check") {
                setTimeout(() => {
                    self.close();
                }, 490);
            }
        },

        computed: {
            type(){
                return this.$store.state.flash.type;
            },

            message(){
                return this.$store.state.flash.message;
            },

        },

        methods: {
            close(){
                let self = this;

                this.flashClass = "flash-box animated fadeOut";

                setTimeout(() => {
                    this.$store.commit('SET_FLASH', {activated : false});
                }, 980);
            }
        }
    }
</script>
