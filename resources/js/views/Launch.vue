<template>
    <loading-view :loading="loading">
        <form v-if="panels.length > 0" @submit.prevent="update" autocomplete="off" class="mb-6">
            <template v-for="panel in panelsWithFields">
                <template v-if="panel.component === 'detail-tabs' || panel.component === 'form-tabs'">
                    <h1 class="text-90 font-normal text-2xl mb-3 nova-heading">{{ panel.name }}</h1>
                    <form-tabs
                        :resource-name="'nova-launch'"
                        :resource-id="'settings'"
                        :errors="validationErrors"
                        :field="{ component: 'tabs', fields: panel.fields }"
                        :name="panel.name"
                        class="mb-3"
                    />
                </template>
                <form-panel
                    v-else
                    :panel="panel"
                    :name="panel.name"
                    :key="panel.name"
                    :fields="panel.fields"
                    :resource-name="'nova-launch'"
                    :resource-id="'settings'"
                    mode="form"
                    class="mb-6"
                    :validation-errors="validationErrors"
                />
            </template>
            <!-- Update Button -->
            <div class="flex items-center">
                <progress-button type="submit" :disabled="isUpdating" :processing="isUpdating">
                    {{ __('novaLaunch.saveSettings') }}
                </progress-button>
            </div>
        </form>

        <div class="flex">
            <card class="bg-90 flex flex-col p-6 mr-6 w-1/2">
                <svg
                    class="fill-80 my-6"
                    width="72"
                    height="72"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M16.21 16.95a5 5 0 0 1-4.02 4.9l-3.85.77a1 1 0 0 1-.9-.27l-.71-.7a2 2 0 0 1 0-2.83l1.44-1.45a13.17 13.17 0 0 1-1.42-1.41L5.31 17.4a2 2 0 0 1-2.83 0l-.7-.7a1 1 0 0 1-.28-.9l.77-3.86a5 5 0 0 1 4.9-4.02h.86a13.07 13.07 0 0 1 12.82-5.47 1 1 0 0 1 .83.83A12.98 12.98 0 0 1 16.2 16.1v.85zm-4.41 2.94a3 3 0 0 0 2.41-2.94v-1.4a1 1 0 0 1 .47-.84A11.04 11.04 0 0 0 19.8 4.33 10.98 10.98 0 0 0 9.42 9.45a1 1 0 0 1-.85.47h-1.4a3 3 0 0 0-2.94 2.4l-.66 3.34.33.33 2.24-2.24a1 1 0 0 1 1.52.12 11.08 11.08 0 0 0 2.6 2.6 1 1 0 0 1 .12 1.52l-2.24 2.24.33.33 3.33-.67zM15 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                        fill-rule="evenodd"/>
                </svg>

                <h2 class="text-white text-4xl text-90 font-light mb-6 font-bold">
                    {{ __('novaLaunch.readyToLaunch') }}
                </h2>

                <p class="text-white text-xl mb-6">
                    {{ __('novaLaunch.whatWillHappen') }}
                </p>

                <p class="text-white text-lg mb-3 flex align-items-center lh-24">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                         class="fill-white icon mr-1">
                        <path class="heroicon-ui"
                              d="M9 10h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h2V7a5 5 0 1 1 10 0 1 1 0 0 1-2 0 3 3 0 0 0-6 0v3zm-4 2v8h14v-8H5zm7 2a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1z"/>
                    </svg>
                    {{ __('novaLaunch.signUpPageRemoved') }}
                </p>

                <p class="text-white text-lg mb-3 flex align-items-center lh-24">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path class="heroicon-ui"
                              d="M9 4.58V4c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v.58a8 8 0 0 1 1.92 1.11l.5-.29a2 2 0 0 1 2.74.73l1 1.74a2 2 0 0 1-.73 2.73l-.5.29a8.06 8.06 0 0 1 0 2.22l.5.3a2 2 0 0 1 .73 2.72l-1 1.74a2 2 0 0 1-2.73.73l-.5-.3A8 8 0 0 1 15 19.43V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.58a8 8 0 0 1-1.92-1.11l-.5.29a2 2 0 0 1-2.74-.73l-1-1.74a2 2 0 0 1 .73-2.73l.5-.29a8.06 8.06 0 0 1 0-2.22l-.5-.3a2 2 0 0 1-.73-2.72l1-1.74a2 2 0 0 1 2.73-.73l.5.3A8 8 0 0 1 9 4.57zM7.88 7.64l-.54.51-1.77-1.02-1 1.74 1.76 1.01-.17.73a6.02 6.02 0 0 0 0 2.78l.17.73-1.76 1.01 1 1.74 1.77-1.02.54.51a6 6 0 0 0 2.4 1.4l.72.2V20h2v-2.04l.71-.2a6 6 0 0 0 2.41-1.4l.54-.51 1.77 1.02 1-1.74-1.76-1.01.17-.73a6.02 6.02 0 0 0 0-2.78l-.17-.73 1.76-1.01-1-1.74-1.77 1.02-.54-.51a6 6 0 0 0-2.4-1.4l-.72-.2V4h-2v2.04l-.71.2a6 6 0 0 0-2.41 1.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    </svg>
                    {{ __('novaLaunch.extraActions') }}
                </p>

                <p class="text-white text-lg mb-3 flex align-items-center lh-24">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                         class="fill-white icon mr-1">
                        <path class="heroicon-ui"
                              d="M6 18.7V21a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2H7.1A7 7 0 0 0 19 12a1 1 0 1 1 2 0 9 9 0 0 1-15 6.7zM18 5.3V3a1 1 0 0 1 2 0v5a1 1 0 0 1-1 1h-5a1 1 0 0 1 0-2h2.9A7 7 0 0 0 5 12a1 1 0 1 1-2 0 9 9 0 0 1 15-6.7z"/>
                    </svg>
                    {{ __('novaLaunch.redirectedAndPluginDisabled') }}
                </p>

                <form @submit.prevent="launch" class="my-6">
                    <div class="flex items-center">
                        <progress-button type="submit" class="btn-lg" :disabled="isUpdating" :processing="isUpdating">
                            {{ __('novaLaunch.goLive') }}
                        </progress-button>

                        <p class="error-text ml-2 text-danger" v-if="launchErrors.has('password')">
                            {{ launchErrors.first('password') }}
                        </p>
                    </div>
                </form>
            </card>

            <card class="bg-90 flex flex-col p-6 ml-6 w-1/2">
                <svg
                    class="fill-80 my-6"
                    width="72"
                    height="72"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 22H4a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h4V8c0-1.1.9-2 2-2h4V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2zM14 8h-4v12h4V8zm-6 4H4v8h4v-8zm8-8v16h4V4h-4z"/>
                </svg>

                <h2 class="text-white text-4xl text-90 font-light mb-6 font-bold">
                    {{ __('novaLaunch.statistics') }}
                </h2>

                <div class="text-white text-lg mb-3 flex align-items-center lh-24">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                         class="fill-white icon mr-1">
                        <path class="heroicon-ui"
                              d="M9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2zm1-5a1 1 0 0 1 0-2 5 5 0 0 1 5 5v2a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3zm-2-4a1 1 0 0 1 0-2 3 3 0 0 0 0-6 1 1 0 0 1 0-2 5 5 0 0 1 0 10z"/>
                    </svg>
                    <p>{{ __('novaLaunch.currentSignups') }} {{ signups }}</p>
                </div>
            </card>
        </div>
    </loading-view>
</template>

<script>
import {Errors} from 'laravel-nova';

export default {
    metaInfo() {
        return {
            title: 'Nova Launch',
        }
    },
    data() {
        return {
            loading: false,
            isUpdating: false,
            fields: [],
            panels: [],
            validationErrors: new Errors(),
            signups: 0,
            launchFields: [],
            launchErrors: new Errors(),
        }
    },
    async created() {
        await this.getFields();
    },
    methods: {
        async getFields() {
            this.loading = true;
            this.fields = [];

            const params = {editing: true, editMode: 'update'};

            const {
                data: {fields, panels, signups},
            } = await Nova.request()
                .get('/nova-vendor/nova-launch/form', {params})
                .catch(error => {
                    if (error.response.status === 404) {
                        this.$router.push({name: '404'});
                    }
                });

            this.fields = fields;
            this.panels = panels;
            this.signups = signups;
            this.loading = false;
        },
        async update() {
            try {
                this.isUpdating = true;

                await this.updateRequest();

                Nova.success(this.__('Settings saved!'));

                await this.getFields();

                this.isUpdating = false;
                this.validationErrors = new Errors();
            } catch (error) {
                console.error(error);

                this.isUpdating = false;

                if (error && error.response && error.response.status === 422) {
                    this.validationErrors = new Errors(error.response.data.errors);
                }
            }
        },
        updateRequest() {
            return Nova.request().post('/nova-vendor/nova-launch/form', this.formData);
        },
        async launch() {
            this.isUpdating = true;
            this.launchFields = [];

            const password = prompt(this.__('novaLaunch.confirmWithPassword'));
            if (!password) {
                this.isUpdating = false;

                return;
            }
            this.launchFields['password'] = password;

            try {
                const response = await this.launchRequest();

                Nova.success(this.__('novaLaunch.siteLaunched'));

                this.isUpdating = false;
                this.launchErrors = new Errors();

                // Redirect away from this page to the given target.
                location.href = response.data.target;
            } catch (error) {
                console.error(error);

                this.isUpdating = false;

                if (error && error.response && error.response.status === 422) {
                    this.launchErrors = new Errors(error.response.data.errors);
                }
            }
        },
        launchRequest() {
            return Nova.request().post('/nova-vendor/nova-launch/launch', this.launchData);
        }
    },
    computed: {
        formData() {
            return _.tap(new FormData(), formData => {
                _(this.fields).each(field => field.fill(formData));
                formData.append('_method', 'POST');
            });
        },
        panelsWithFields() {
            return _.map(this.panels, panel => {
                return {
                    name: panel.name,
                    component: panel.component,
                    fields: _.filter(this.fields, field => field.panel === panel.name),
                };
            });
        },
        launchData() {
            return _.tap(new FormData(), formData => {
                Object.entries(this.launchFields).forEach(field => {
                    const [key, value] = field;
                    formData.append(key, value);
                });
                formData.append('_method', 'POST');
            });
        }
    },
}
</script>

<style scoped>
.lh-24 {
    line-height: 24px;
}
</style>
