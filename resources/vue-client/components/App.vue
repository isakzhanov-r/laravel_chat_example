<template>
    <space>
        <v-fade-transition mode="out-in">
            <router-view />
        </v-fade-transition>
    </space>
</template>

<script>
    import Space from './Space';
    export default {
        name: 'App',
        components:{
            Space
        }
    };
</script>

<style scoped>

</style>
