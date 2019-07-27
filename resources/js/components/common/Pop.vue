<template>
    <div>
        <div :class="className" v-if="poped">
            <div class="content">
                <slot></slot>
            </div>
        </div>
    </div>


</template>
<script>
    export default {
        props: {
            name: {
                required: true
            },

            className: {
                default: "pop"
            }
        },

        mounted(){
        },

        computed: {
            poped() {
                return this.$store.state.poped[this.name];
            }
        }
    }
</script>
<style>

</style>
