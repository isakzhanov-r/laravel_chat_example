<template>
    <div>
        <drawer-section :contacts="items" :not_confirmed="items"/>
        <header-section/>
        <v-content>
            <v-container fluid>
                <v-layout row wrap>
                    <v-slide-y-transition mode="out-in">
                        <router-view></router-view>
                    </v-slide-y-transition>
                </v-layout>
            </v-container>
        </v-content>
        <footer-section/>
    </div>
</template>

<script>
    import Header from './Header';
    import Drawer from './Drawer';
    import Footer from './Footer';

    export default {
        name: 'Index',
        data:()=>({
            items: [
                { icon: true, title: 'Jason Oner', avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg' },
                { title: 'Travis Howard', avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg' },
                { title: 'Ali Connors', avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg' },
                { title: 'Cindy Baker', avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg' },
            ],
        }),
        components: {
            'header-section': Header,
            'drawer-section': Drawer,
            'footer-section': Footer
        },
        computed: {
            user() {
                return this.$store.getters['auth/user'];
            }
        }
    };
</script>

<style scoped>

</style>
