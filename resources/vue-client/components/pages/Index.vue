<template>
    <div>
        <drawer-section :user="user" :contacts="contacts" :requested="requested"/>
        <header-section :notifications="{excepted,messages:not_read_messages}"/>
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
        components: {
            'header-section': Header,
            'drawer-section': Drawer,
            'footer-section': Footer
        },
        computed: {
            user() {
                return this.$store.getters['auth/user'];
            },
            contacts() {
                return this.$store.getters['contacts/contacts'];
            },
            requested() {
                return this.$store.getters['contacts/requested'];
            },
            excepted() {
                return this.$store.getters['contacts/excepted'];
            },
            not_read_messages(){
                return this.$store.getters['messages/not_read_messages'];
            }
        },
        created() {
            this.newContacts();
            this.newMessages();
            this.$store.dispatch('contacts/getContacts');
            this.$store.dispatch('contacts/getExcepted');
            this.$store.dispatch('messages/getNotReadMessages');
        },
        methods: {
            newContacts() {
                this.$echo.private(`new_contacts.${this.user.id}`)
                    .listen('Contacts\\AddEvent', ({contact}) => {
                        this.$store.commit('contacts/addExcepted', {contact: contact});
                    });
            },
            newMessages() {
                this.$echo.private(`new_messages.${this.user.id}`)
                    .listen('Messages\\SendEvent', ({message}) => {
                        this.$store.commit('messages/addMessages', {message: message});
                    });
            }
        }
    };
</script>

<style scoped>

</style>
