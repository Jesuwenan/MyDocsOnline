<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('helps.index')">Aide</inertia-link>
                        </div>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Vous avez une question sur l'utilisation du programme?</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white rounded shadow overflow-hidden ">
            <form @submit.prevent="submit" novalidate>
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="name">Nom *:</label>
                            <input v-model="form.name" ref="name" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"/>
                            <div v-if="errors.name" class="text-red-700 mt-2 text-sm">{{ errors.name }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="phone">Téléphone *:</label>
                            <vue-tel-input :value="phone" @input="onInput" mode="international" defaultCountry="BE" :enabledCountryCode="true" :validCharactersOnly="true" :inputOptions="inputOptions" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></vue-tel-input>
                            <div v-if="errors.phone" class="text-red-700 mt-2 text-sm">{{ errors.phone }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email *:</label>
                            <input v-model="form.email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="email"  />
                            <div v-if="errors.email" class="text-red-700 mt-2 text-sm">{{ errors.email }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="email">Question *:</label>
                            <textarea v-model="form.question" name="question" id="question" rows="5"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"></textarea>
                            <div v-if="errors.question" class="text-red-700 mt-2 text-sm">{{ errors.question }}</div>
                        </div>

                    </div>
                   
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Envoyez</loading-button>
                </div>
            </form>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

export default {
   
    components: {
        LoadingButton,
        TextInput,
        SelectInput,
        VueTelInput
    },
    props: {
        company: Object,
        errors: Object,
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            form: {
                name: null,
                country_code: null,
                email: null,
                number: null,
                phone: null,
                question: null
            },
            phone: null,
            selected: null,
            inputOptions:{
                placeholder:'Entrez votre n° de téléphone'
            }
            
           
        }
    },
    methods: {
        
        submit() {
            
            this.$inertia.post(this.route('helps.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
        },
        chooseTab(tag) {
            this.currentTab = tag;
        },
        onInput(phone, phoneObject, input) {
            if (phoneObject?.formatted) {
                this.form.country_code = phoneObject.countryCode
                this.phone = phoneObject.formatted
                this.form.phone = phoneObject.nationalNumber
                this.form.number = phoneObject.number
            }
        },
    },
    mounted () {
        this.$refs.name.focus();
    },
    
}
</script>

