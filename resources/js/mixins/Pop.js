export default {
    methods: {
        openPop(name){
            this.$store.dispatch('pop', {activated:true, name:name});
        },

        closePop(name){
            this.$store.dispatch('pop', {activated:false, name:name});
        }
    }
};
