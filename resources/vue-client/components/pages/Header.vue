<template>
    <v-content>
        <v-toolbar
                id="core-toolbar"
                dense
                dark
                style="background: #424242;">

            <v-toolbar-title class="tertiary--text font-weight-light">
                {{ title }}
            </v-toolbar-title>
            <v-spacer/>
            <v-menu
                    v-if="notifications.excepted.length > 0 || notifications.messages.length > 0"
                    bottom
                    left
                    content-class="dropdown-menu"
                    offset-y
                    transition="slide-y-transition">
                <template v-slot:activator="{ on }">
                    <v-btn color="grey darken-3" v-on="on" fab dark>
                        <v-badge color="error" overlap>
                            <template slot="badge">{{ notifications.excepted.length + notifications.messages.length }}</template>
                            <v-icon color>mdi-bell</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card v-if="notifications.excepted.length > 0">
                    <v-card-text>
                        <v-list dense>
                            <v-list-item-title>Запросы на добавление в контакты</v-list-item-title>
                            <v-list-item v-for="item in notifications.excepted" :key="item.id" @click="openContact(item)">
                                <v-list-item-avatar>
                                    <v-img :src="item.avatar"></v-img>
                                </v-list-item-avatar>

                                <v-list-item-content>
                                    <v-list-item-title v-text="item.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
                <v-card v-if="notifications.messages.length > 0">
                    <v-card-text>
                        <v-list dense>
                            <v-list-item-title>Непрочитанные сообщения</v-list-item-title>
                            <v-list-item v-for="notification in notifications.messages" :key="notification.message">
                                <v-list-item-content>
                                    <v-list-item-title v-text="getContactName(notification.from)"></v-list-item-title>
                                    {{ notification.message }}
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-menu>
            <v-menu
                    bottom
                    left
                    content-class="dropdown-menu"
                    offset-y
                    transition="slide-y-transition">
                <template v-slot:activator="{ on }">
                    <v-btn color="grey darken-3" v-on="on" fab dark>
                        <v-icon>mdi-account-circle</v-icon>
                    </v-btn>
                </template>

                <v-card>
                    <v-list dense>
                        <v-list-item :to="{name:'profile'}">
                            <v-list-item-content>
                                <v-list-item-title>Настройки</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click.stop="confirmLogout = true">
                            <v-list-item-content>
                                <v-list-item-title>Выход</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </v-toolbar>
        <v-dialog
                v-model="confirmLogout"
                max-width="410">
            <v-card>
                <v-card-title class="headline">Вы уверены что хотите выйти?</v-card-title>
                <v-card-actions>
                    <v-btn
                            dark
                            color="warning"
                            @click="logout">
                        Да
                    </v-btn>
                    <v-spacer/>
                    <v-btn
                            dark
                            color="success"
                            @click="confirmLogout = false"
                    >
                        Нет
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
                v-if="item"
                v-model="confirmContact"
                max-width="410">
            <v-card class="mx-auto">
                <v-img
                        src="https://cdn.vuetifyjs.com/images/lists/ali.png"
                        height="300px"
                        dark>
                    <v-row class="fill-height">
                        <v-card-title>
                            <v-btn dark icon>
                                <v-icon>mdi-chevron-left</v-icon>
                            </v-btn>
                            Добавить контакт
                        </v-card-title>

                        <v-spacer></v-spacer>

                        <v-card-title class="white--text pl-12 pt-12">
                            <div class="display-1 pl-12 pt-12">{{ item.name}}</div>
                        </v-card-title>
                    </v-row>
                </v-img>

                <v-list two-line>
                    <v-list-item @click="">
                        <v-list-item-icon>
                            <v-icon color="indigo">mdi-email</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.email }}</v-list-item-title>
                            <v-list-item-subtitle>Personal</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            v-if="!item.confirmed"
                            color="deep-purple lighten-2"
                            text
                            @click="confirm"
                    >
                        Добавить
                    </v-btn>
                    <v-btn
                            color="deep-purple lighten-2"
                            text
                            @click="confirmContact = false"
                    >
                        Закрыть
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-content>
</template>

<script>
    export default {
        name: 'Header',
        props: {
            notifications: {
                type: [Array, Object],
                default: function () {
                    return [];
                }
            }
        },
        data: () => ({
            title: null,
            confirmLogout: false,
            confirmContact: false,
            item: null
        }),
        mounted() {
            this.title = this.$route.meta.title;
        },
        watch: {
            '$route'(route) {
                this.title = route.meta.title;
            }
        },
        methods: {
            openContact(contact) {
                this.item = contact;
                this.confirmContact = true;
            },
            confirm() {
                this.$axios.post('/api/contacts/confirm', {contact_id: this.item.id})
                    .then(response => {
                        this.$store.commit('contacts/addContact', {contact: response.data.data});
                        this.confirmContact = false;
                        this.find.item = null;
                    });
            },
            getContactName(id) {
                let contact = _.find(this.$parent.contacts, contact => {
                    return contact.id === parseInt(id);
                });
                if (contact) {
                    return contact.name;
                }
            },
            logout() {
                let _result = this.$store.dispatch('auth/logout');
                if (_result) {
                    location.reload();
                }
            }
        }

    };
</script>

<style lang="scss">
    #core-toolbar a {
        text-decoration: none;
    }
</style>
