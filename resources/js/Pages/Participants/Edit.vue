<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('participants.index')">Participants</inertia-link>
                        </div>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Modifier un participant</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white rounded shadow " v-show="currentTab==='details'">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-12 sm:col-span-6">
                            <div v-if="errors.person_id" class="text-red-700 mt-2 text-sm">{{ errors.person_id }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="bank_account_number">Entreprise *:</label>
                            <VueMultiselect
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.company"
                                @select="companySelection"
                                @remove="removeCompany"
                                :disabled="$page.props.user.is_admin===1 ? false : true"
                                :multiple="false"
                                track-by="id"
                                label="name"
                                :options="companies">
                            </VueMultiselect>
                            <div v-if="errors.company_id" class="text-red-700 mt-2 text-sm">{{ errors.company_id }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="bank_account_number">Evénements *:</label>
                            <VueMultiselect
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.event"
                                @select="selectEvent"
                                @remove="removeEvent"
                                :disabled="$page.props.user.is_admin===1 ? false : true"
                                :multiple="false"
                                track-by="id"
                                label="name"
                                :options="events">
                            </VueMultiselect>
                            <div v-if="errors.event_id" class="text-red-700 mt-2 text-sm">{{ errors.event_id }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="phone">Téléphone *:</label>
                            <vue-tel-input :value="phone" @input="onInput" mode="international" defaultCountry="BE" :inputOptions="inputOptions" :enabledCountryCode="true" :validCharactersOnly="true" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></vue-tel-input>
                            <div v-if="errors.number" class="text-red-700 mt-2 text-sm">{{ errors.number }}</div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email *:</label>
                            <input @blur="searchPerson()" v-model="form.email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="email"  />
                            <div v-if="errors.email" class="text-red-700 mt-2 text-sm">{{ errors.email }}</div>
                        </div>

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
                            <label class="block text-sm font-medium text-gray-700" for="bank_account_number">Droit:</label>
                            <VueMultiselect
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="form.event_droit"
                                :multiple="false"
                                track-by="id"
                                label="name"
                                :options="event_droits">
                            </VueMultiselect>
                            <div v-if="errors.event_droit" class="text-red-700 mt-2 text-sm">{{ errors.event_droit }}</div>
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
import VueMultiselect from 'vue-multiselect'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'
export default {

    
    components: {
        LoadingButton,
        TextInput,
        SelectInput, 
        VueMultiselect,
        VueTelInput     
    },
    props: {
        participant: Object,
        companies: Array,
        event: Object,
        events: Array,
        company: Object,
        event_droits: Array,
        participant_has_event_droit: Object,
        errors: Object,
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            form: {
                company: this.participant.company,
                first_name: this.participant.person.first_name,
                last_name: this.participant.person.last_name,
                national_registry: this.participant.person.national_registry!=null ? this.participant.person.national_registry : '',
                address: this.participant.person.address,
                postal_code: this.participant.person.postal_code,
                city: this.participant.person.city,
                email: this.participant.person.email,
                phone: null,
                number: null,
                company_id: this.participant.company.id,
                event: this.participant.event,
                event_id:this.participant.event_id,
                event_droit: this.participant_has_event_droit?.event_droit,
                person_id: this.participant.person.id
            },
            inputOptions:{
                placeholder:'Entrez votre n° de téléphone'
            },
            phone: this.participant.person.phone,
            selected: null,
            autocomplete: null,
            currentTab : 'details',

        }
    },
    methods: {
        submit() {
            
            this.$inertia.put(this.route('participants.update',this.participant.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
        },
        searchPerson(){

            if(this.form.email) {
                let self = this
                axios({
                    method:'post',
                    url:"/api/search-person",
                    data:{
                        email: this.form.email,
                    },
                }).then((response)=>{
                    //console.log(response.data.status)
                    if(response.data.status){
                        this.form.last_name = response.data.person.last_name
                        this.form.first_name = response.data.person.first_name
                        this.form.address = response.data.person.address
                        this.form.city = response.data.person.city
                        this.form.postal_code = response.data.person.postal_code
                        this.form.email = response.data.person.email
                        //this.phone = response.data.person.phone
                        this.form.national_registry = response.data.person.national_registry
                        this.form.person_id = response.data.person.id
                    }else{
                        self.form.last_name = null
                        self.form.first_name = null
                        self.sending = false
                        self.form.address = null
                        self.form.city = null
                        self.form.postal_code = null
                        //self.form.phone = null
                        self.form.national_registry = null
                        self.form.person_id = null
                    }

                }).catch(function(error) {
                   
                    self.form.last_name = null
                    self.form.first_name = null
                    self.sending = false
                    self.form.address = null
                    self.form.city = null
                    self.form.postal_code = null
                    //self.form.phone = null
                    self.form.national_registry = null
                    self.form.person_id = null
                
                })
                //console.log('search')
            }
        },
        chooseTab(tag) {
            this.currentTab = tag;
        },
        companySelection(company){
            this.form.company_id = company.id
            this.form.company = company
        },
        removeCompany()
        {
            this.form.company = null
            this.form.company_id = null
        },
        selectEvent(event)
        {
            this.form.event_id = event.id
        },
        removeEvent()
        {
            this.form.event = null
            this.form.event_id = null
        },
        onInput(phone, phoneObject, input) {
            if (phoneObject?.formatted) {
                //console.log(phoneObject)
                this.form.country_code = phoneObject.countryCode
                this.phone = phoneObject.formatted
                this.form.phone = phoneObject.nationalNumber
                this.form.number = phoneObject.number
                let self = this
                axios({
                    method:'post',
                    url:"/api/search-person",
                    data:{
                        phone: this.form.number,
                    },
                }).then((response)=>{
                        //console.log(response.data.status)
                    if(response.data.status){
                        this.form.last_name = response.data.person.last_name
                        this.form.first_name = response.data.person.first_name
                        this.form.address = response.data.person.address
                        this.form.city = response.data.person.city
                        this.form.postal_code = response.data.person.postal_code
                        this.form.email = response.data.person.email
                        this.phone = response.data.person.phone
                        this.form.national_registry = response.data.person.national_registry
                        this.form.person_id = response.data.person.id
                    }else{
                        self.form.last_name = null
                        self.form.first_name = null
                        self.sending = false
                        self.form.address = null
                        self.form.city = null
                        self.form.postal_code = null
                        self.form.national_registry = null
                        self.form.person_id = null
                        self.form.email = null
                    }

                }).catch(function(error) {
                    self.form.last_name = null
                    self.form.first_name = null
                    self.sending = false
                    self.form.address = null
                    self.form.city = null
                    self.form.postal_code = null
                    // self.form.phone = null
                    self.form.national_registry = null
                    self.form.person_id = null
                    self.form.email = null
                })
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