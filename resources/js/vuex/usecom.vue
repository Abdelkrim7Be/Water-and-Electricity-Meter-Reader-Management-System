<template>
    <div class="content">
        <div class="container-fluid">
            <h1>i will show you how all the other components are gathered!</h1>
            the current state of counter is : {{ $store.state.counter }}
            <h2>The master component : {{ counter }}</h2>
        </div>
        <div>
            <comA></comA>
        </div>
        <div>
            <comB></comB>
        </div>
        <div>
            <comC></comC>
        </div>

        <Button type="info" @click="changeCounter">change counter</Button>
    </div>
</template>


<script>
import comA from './comA';
import comB from './comB';
import comC from './comC';
import { mapActions, mapGetters } from 'vuex';
export default {
    data() {
        return {
            localVar : 'some sort of  vars',
        }
    },
    methods: {
        ...mapActions([
            'changecounterAction'
        ]),     
    },
    computed: {
        // ...mapGetters(['getCounter']),
        ...mapGetters({
            'counter' : 'getCounter'
        }),
    },  
    methods: {
        changeCounter() {
            this.$store.dispatch('changeCounterAction', 1);
            // this.$store.commit('changeTheCounter', 1);
            // we are dispatching an action instead of commiting a mutation directly
            // the mutation functions are not asynchronous, but actions are asynchronous
        },
        runSomethingWhenTheCounterChange() {
            console.log('i am running this when a change is happening');
        },
    },
    created() {
        console.log(this.$store.state.counter);
    },
    components: {
        comA,
        comB,
        comC,
    },
    watch: {
        counter(value) {
            console.log('counter  is changing ', value);
            this.runSomethingWhenTheCounterChange();
            console.log(this.localVar);
        }

    }
}
</script>