<template>
    <v-container fill-height fluid grid-list-xl class="footer-absolute">
        <v-layout justify-center wrap>
            <v-flex xs12 md6>
                <v-card>
                    <v-form @submit.prevent="sendForm">
                        <v-card-title>Profile</v-card-title>
                        <v-card-text>

                            <v-container py-0>
                                <v-layout wrap>
                                    <v-flex xs12 md6>
                                        <v-text-field
                                                v-model="form.name"
                                                :error="hasError('name')"
                                                :error-messages="getMessage('name')"
                                                label="Имя пользователя"
                                                type="text"
                                        />
                                    </v-flex>
                                    <v-flex xs12 md6>
                                        <v-text-field
                                                disabled
                                                label="Email"
                                                v-model="user.email"/>
                                    </v-flex>
                                    <v-flex xs12 md6>
                                        <v-checkbox
                                                v-model="form.change_password"
                                                label="Изменить пароль"
                                                required
                                        ></v-checkbox>
                                    </v-flex>
                                </v-layout>
                            </v-container>

                        </v-card-text>
                        <v-expand-transition>
                            <div v-show="form.change_password">
                                <v-divider></v-divider>

                                <v-card-text>
                                    <v-container py-0>
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="form.old_password"
                                                        :error="hasError('old_password')"
                                                        :error-messages="getMessage('old_password')"
                                                        label="Старый пароль"
                                                        type="password"
                                                />
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="form.password"
                                                        :error="hasError('password')"
                                                        :error-messages="getMessage('password')"
                                                        label="Новый пароль"
                                                        type="password"
                                                />
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="form.password_confirmation"
                                                        type="password"
                                                        label="Подтверждение нового пароля"
                                                />
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                            </div>
                        </v-expand-transition>
                        <v-container py-0>
                            <v-layout wrap>
                                <v-flex xs12 text-xs-right>
                                    <v-btn class="mx-0 font-weight-light"
                                           :loading="loading"
                                           :disabled="loading"
                                           type="submit"
                                           color="success">
                                        Update Profile
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import _ from 'lodash';

    export default {
        name: 'Profile',
        data: () => ({
            form: {
                name: null,
                change_password: false,
                old_password: null,
                password: null,
                password_confirmation: null
            },
            loading: false,
            errors: null,
            snackbar: {
                show: false,
                text: ''
            }
        }),
        computed: {
            user() {
                var user = this.$store.getters['auth/user'];
                this.form.name = user.name;

                return user;
            }
        },

        methods: {
            hasError(name) {
                return _.has(this.errors, name);
            },
            getMessage(name) {
                return _.get(this.errors, name);
            },
            sendForm() {
                this.errors = null;
                this.loading = true;
                this.$axios.put('/api/user/' + this.user.id, this.form)
                    .then(response => {
                        this.snackbar.show = true;
                        this.snackbar.text = 'Ваши данные успешно обновлены';
                        this.form.change_password = false;
                        this.form.old_password = null;
                        this.form.password = null;
                        this.form.password_confirmation = null;
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    }).finally(() => {
                    this.loading = false;

                });
            }
        }
    };
</script>

<style scoped>

</style>
