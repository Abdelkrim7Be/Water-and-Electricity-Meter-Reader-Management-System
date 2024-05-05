<template>
    <div>
        <h1 ref="karim">Hook tutoriel</h1>
        <p>My name is : {{ name }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: 'karim',
        }
    },

    beforeCreate() {
        console.log('hello before Created');
    },

    created() {
        // console.log(this.$ref);
        // call initial data from it....
        console.log('data and other variable are avaible but not html', this.name);
    },

    mounted() {
        console.log(this.$refs.karim);
    },
}
</script>