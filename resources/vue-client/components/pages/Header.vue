<template>
    <v-content>
        <v-toolbar
                id="core-toolbar"
                dense
                style="background: #EEEEEE;">

            <v-toolbar-title class="tertiary--text font-weight-light">
                {{ title }}
            </v-toolbar-title>
            <v-spacer/>
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
    </v-content>
</template>

<script>
    export default {
        name: 'Header',
        data: () => ({
            title: null,
            confirmLogout: false
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
            logout() {
                let _result = this.$store.dispatch('auth/logout');
                if (_result) {
                    location.reload()
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
