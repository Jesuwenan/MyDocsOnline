<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <flash-messages />
        <div class=" px-4 pb-5 sm:flex sm:items-center sm:justify-between">
            <p>
                Vous êtes invité pour l'événement <strong class="">{{participant.event.name}}</strong>  par l'entreprise : 
                <strong class="">{{participant.company.name}}</strong>
            </p>

            
        </div>

        <div class="bg-white rounded  overflow-hidden">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="last_name">Nom *:</label>
                            <input v-model="form.last_name" name="last_name" id="last_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.last_name" class="text-red-700 mt-2 text-sm">{{ errors.last_name }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="first_name">Prénom *:</label>
                            <input v-model="form.first_name" name="first_name" id="first_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.first_name" class="text-red-700 mt-2 text-sm">{{ errors.first_name }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="national_registry">Registre National (99.99.99-999.99):</label>
                            <input @keydown="autoCompleteNationalRegistry" ref="national_registry" v-model="form.national_registry" name="national_registry" id="national_registry" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text" maxlength="15" autocomplete="off" />
                            <div v-if="errors.national_registry" class="text-red-700 mt-2 text-sm">{{ errors.national_registry }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="address">Adresse:</label>
                            <input v-model="form.address" ref="address" name="address" id="address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.address" class="text-red-700 mt-2 text-sm">{{ errors.address }}</div>
                        </div>

                        <div class="col-span-4 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700" for="postal_code">Code postal:</label>
                            <input v-model="form.postal_code" name="postal_code" id="postal_code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.postal_code" class="text-red-700 mt-2 text-sm">{{ errors.postal_code }}</div>
                        </div>

                        <div class="col-span-8 sm:col-span-4">
                            <label class="block text-sm font-medium text-gray-700" for="city">Ville:</label>
                            <input v-model="form.city" name="city" id="city" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.city" class="text-red-700 mt-2 text-sm">{{ errors.city }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email *:</label>
                            <input v-model="form.email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="email"  />
                            <div v-if="errors.email" class="text-red-700 mt-2 text-sm">{{ errors.email }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="phone">Téléphone *:</label>
                            <vue-tel-input :value="phone" @input="onInput" mode="international" defaultCountry="BE" :inputOptions="inputOptions" :enabledCountryCode="true" :validCharactersOnly="true" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></vue-tel-input>
                            <div v-if="errors.phone" class="text-red-700 mt-2 text-sm">{{ errors.phone }}</div>
                        </div>

                        <!-- <div class="col-span-12 sm:col-span-6">
                            <div class="flex items-center">
                                <input value="abandonment of claim" id="abandonment_of_claim" v-model="form.abandonment_of_claim" name="abandonment_of_claim" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="abandonment of claim" class="ml-3 block text-sm font-medium text-gray-700">
                                    Besoin de l’abandon de recours (oui/non)
                                </label>
                            </div>
                        </div> -->

                        <div class="col-span-12 sm:col-span-6" v-if="participant.event.abandonment_of_claim===1">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="term_and_condition" v-model="form.term_and_condition" name="term_and_condition" checked  type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span for="term_and_condition"  class="font-medium text-gray-700">
                                        J'ai lu et j'accepte 
                                        <a class=" mb-1  text-sm leading-4  focus:text-blue-500 text-blue-500" :href="route('participants.condition.general')" target="_blank">
                                            les conditions générales
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 mt-2 space-y-4">

                            <div class="flex items-center">
                                <input value="Vacciné" id="vaccinated" v-model="form.about_covid" name="about_covid" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="vaccinated" class="ml-3 block text-sm font-medium text-gray-700">
                                    Je certifie sur l’honneur que je suis entièrement vacciné.
                                </label>
                            </div>
                            <!-- <div class="flex items-center">
                                <input value="Test PCR" id="pcr_test" v-model="form.about_covid" name="about_covid" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                <label for="pcr_test" class="ml-3 block text-sm font-medium text-gray-700">
                                    Je ne suis pas vacciné, je présenterai un test PCR négatif daté de maximum 48h avant la date de l'événement.
                                </label>
                            </div> -->
                            <div class="flex items-center">
                                <div v-if="errors.about_covid" class="text-red-700 mt-2 text-sm">{{ errors.about_covid }}</div>
                            </div>

                        </div>
                        
                    </div>
                </div>
                <div class="px-8 py-4 flex justify-center items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-400 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Confirmer mon invitation</loading-button>
                </div>
            </form>
        </div>


      </div>
    </div>
  </div>
</template>

<script>

import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import VueMultiselect from 'vue-multiselect'
import FlashMessages from '@/Shared/FlashMessages'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'
export default {

    components: {
        LoadingButton,
        TextInput,
        SelectInput, 
        VueMultiselect,
        FlashMessages ,
        VueTelInput     
    },
    props: {
        participant: Object,
        errors: Object,
    },
    data() {
        return {
            sending: false,
            form: {
                participant_id: this.participant.id,
                first_name: this.participant.person.first_name,
                last_name: this.participant.person.last_name,
                national_registry: this.participant.person.national_registry!=null ? this.participant.person.national_registry : '',
                address: this.participant.person.address,
                postal_code: this.participant.person.postal_code,
                city: this.participant.person.city,
                email: this.participant.person.email,
                phone: null,
                number: null,
                term_and_condition: true,
                about_covid:null,
                company_id: this.participant.company.id,
                person_id: this.participant.person.id
            },
            inputOptions:{
                placeholder:'Entrez votre n° de téléphone'
            },
            phone:  this.participant.person.phone,
            selected: null,
            autocomplete: null,
            currentTab : 'details',

        }
    },
    methods: {
        submit() {
            
            this.$inertia.post(this.route('participants.confirm'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
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

        //document.getElementById("company").focus();
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

<style src="vue-multiselect/dist/vue-multiselect.css"></style>