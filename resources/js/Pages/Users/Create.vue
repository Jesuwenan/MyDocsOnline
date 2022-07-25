<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('users.index')">Utilisateurs</inertia-link>
                        </div>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Créer un utilisateur</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white rounded shadow overflow-hidden " v-show="currentTab==='details'">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="last_name">Nom *:</label>
                            <input v-model="form.last_name" ref="last_name" name="last_name" id="last_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.last_name" class="text-red-700 mt-2 text-sm">{{ errors.last_name }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="first_name">Prénom *:</label>
                            <input v-model="form.first_name" name="first_name" id="first_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.first_name" class="text-red-700 mt-2 text-sm">{{ errors.first_name }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="username">Nom d'utilisateur *:</label>
                            <input v-model="form.username" name="username" id="username" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.username" class="text-red-700 mt-2 text-sm">{{ errors.username }}</div>
                        </div>
                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="email">Sexe *:</label>
                            <select name="sexe" id="sexe" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model = "form.sexe">
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                        </div>
                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email *:</label>
                            <input v-model="form.email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="email"  />
                            <div v-if="errors.email" class="text-red-700 mt-2 text-sm">{{ errors.email }}</div>
                        </div>
                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="phone">Téléphone *:</label>
                            <vue-tel-input :value="phone" @input="onInput" mode="international" :inputOptions="inputOptions" defaultCountry="BJ" :enabledCountryCode="true" :validCharactersOnly="true" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></vue-tel-input>
                            <div v-if="errors.phone" class="text-red-700 mt-2 text-sm">{{ errors.phone }}</div>
                        </div>

                    </div>
                   
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Enregistrer</loading-button>
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
import JetCheckbox from '@/Jetstream/Checkbox'
import VueMultiselect from 'vue-multiselect'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

export default {
   
    components: {
        LoadingButton,
        TextInput,
        SelectInput,
        VueTelInput,
        JetCheckbox,
        VueMultiselect,
        
    },
    props: {
        errors: Object,
        sexe: Array,
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            form: {
                first_name: null,
                last_name: null,
                national_registry: '',
                country_code: null,
                address: null,
                postal_code: null,
                city: null,
                email: null,
                number: null,
                phone: null,
            },
            inputOptions:{
                placeholder:'Entrez votre n° de téléphone'
            },
            phone: null,
            selected: null,
            autocomplete: null,
            currentTab : 'details',
            
           
        }
    },
    methods: {
        
        submit() {
            
            this.$inertia.post(this.route('users.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
        },
        chooseTab(tag) {
            this.currentTab = tag;
        },
        onInput(phone, phoneObject, input) {
            if (phoneObject?.formatted) {
                //console.log(phoneObject)
                this.form.country_code = phoneObject.countryCode
                this.phone = phoneObject.formatted
                this.form.phone = phoneObject.nationalNumber
                this.form.number = phoneObject.number
            }
        },

        setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        },
        autoCompleteNationalRegistry(e){
            //console.log(e.keyCode)
            if(e.keyCode===65 || e.keyCode===86){
                e.preventDefault();
            }

            if(e.keyCode != 8 && this.form.national_registry.length===2 || this.form.national_registry.length===5 || this.form.national_registry.length===12){
                this.form.national_registry = this.form.national_registry+'.'
            }

            if(e.keyCode != 8 && this.form.national_registry.length===8){
                this.form.national_registry = this.form.national_registry+'-'
            }

            if(e.keyCode == 8){
                let national_registry_array = this.form.national_registry.split('')
                
                if(this.form.national_registry.length===13){
                    this.form.national_registry = ''
                    for (let index = 0; index < 12; index++) {
                        this.form.national_registry = this.form.national_registry+national_registry_array[index];
                    }
                }

                if(this.form.national_registry.length===6){
                    this.form.national_registry = ''
                    for (let index = 0; index < 5; index++) {
                        this.form.national_registry = this.form.national_registry+national_registry_array[index];
                    }
                }
            }
            
        }
      
    },
    mounted () {

        this.$refs.last_name.focus();
        
        // this.setInputFilter(this.$refs.national_registry, function(value) {
        //     return /\d{2}[.]\d{2}[.]\d{2}[-]\d{3}[.]\d{2}$/.test(value);
        // });
        //this.countryChange(this.countryChange)

        this.autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement}*/(this.$refs.address),
            { types: ['geocode'] }
        );
        
        this.autocomplete.addListener('place_changed', () => {
            const place = this.autocomplete.getPlace();
            // contient le pays, la ville le code postal, etc...
            for (let index = 0; index < place.address_components.length; index++) {
                const element = place.address_components[index];
                switch (element.types[0]) {
                   
                    case 'route':
                        this.form.address  = element.short_name
                        break;
                    case 'locality':
                        this.form.city  = element.long_name
                        break;
                    case 'postal_code':
                        this.form.postal_code  = element.long_name
                        break;
                    default:
                        break;
                }
                
            }

        });
    },
    
}
</script>

