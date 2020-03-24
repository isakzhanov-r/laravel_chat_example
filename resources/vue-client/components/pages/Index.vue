<template>
    <div id="wrapper">
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
    import _ from 'lodash';

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
            not_read_messages() {
                let messages = this.$store.getters['messages/not_read_messages'];
                return _.filter(messages, message => {
                    return message.to === this.user.id && message.from !== parseInt(this.$route.params.contact_id);
                });
            }
        },
        mounted() {
            this.newContacts();
            this.newMessages();
            this.confirmContacts();
            this.$store.dispatch('contacts/getContacts');
            this.$store.dispatch('contacts/getExcepted');
            this.$store.dispatch('messages/getNotReadMessages');
        },
        methods: {
            confirmContacts() {
                this.$echo.private(`confirm_contacts.${this.user.id}`)
                    .listen('Contacts\\ConfirmEvent', ({user}) => {
                        this.$store.commit('contacts/addContact', {contact: user});
                    });
            },
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
    #wrapper {
        overflow: hidden;
        overflow-y: scroll;
    }
</style>
