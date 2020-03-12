<template>
    <v-navigation-drawer
            id="app-drawer"
            app
            dark
            floating
            persistent
            v-model="drawer"
            :mini-variant.sync="mini"
            permanent
            mobile-break-point="991"
            width="260"
            :src="image"
            height="100%">
        <v-list-item class="px-2" style="min-height:70px">
            <v-list-item-avatar color="white">
                <v-img :src="icon"/>
            </v-list-item-avatar>
            <v-list-item-title>
                Vuetify MD
            </v-list-item-title>
            <v-btn icon @click.stop="mini = !mini">
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
        </v-list-item>
        <v-divider/>
        <v-list subheader>
            <v-toolbar>
                <v-toolbar-title class="white--text">Контакты</v-toolbar-title>
                <template v-slot:extension>
                    <v-btn
                            fab
                            color="cyan accent-2"
                            bottom
                            left
                            absolute
                            @click="dialog = !dialog"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-toolbar>
            <v-divider/>
            <v-list-item
                    v-for="item in contacts"
                    :key="item.title"
                    @click=""
            >
                <v-list-item-avatar>
                    <v-img :src="item.avatar"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item-content>

                <v-list-item-icon>
                    <v-icon v-if="item.icon" color="pink">mdi-star</v-icon>
                </v-list-item-icon>
            </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list subheader>
            <v-subheader>Ждут ответа</v-subheader>

            <v-list-item
                    v-for="item in not_confirmed"
                    :key="item.title"
                    @click=""
            >
                <v-list-item-avatar>
                    <v-img :src="item.avatar"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: 'Drawer',
        props: {
            contacts: Array,
            not_confirmed: Array
        },
        data: () => ({
            drawer: true,
            mini: false,
            title: 'VueMax Admin',
            image: null,
            icon: require('~client/assets/images/favicon.png')
        }),
        created() {
            this.getImage(6, 1);
        },
        methods: {
            getImage(max, min) {
                var num = Math.floor(Math.random() * (max - min) + min);
                this.image = require('~client/assets/images/sidebar-' + num + '.jpg');
            }
        }
    };
</script>

<style lang="scss">
    #app-drawer {
        &.v-navigation-drawer {
            background: inherit;
        }

        .v-list-item__title {
            border-radius: 4px;

            &--buy {
                margin-top: auto;
                margin-bottom: 17px;
            }
        }

        .v-list-item {
            margin: 0;

            &--active {
                color: #FFFFFF;

                &:before {
                    opacity: 0;
                }
            }
        }
    }
</style>
