<template>
  <div class="mt-8" v-on:keyup.enter="confirm()" v-on:keyup.esc="cancel()">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 sm:flex sm:items-center sm:justify-between">
          

          <div class="flex">

            <h3 class="text-3xl font-extrabold text-gray-900">
              Documents
            </h3>

            <div class="mt-3 sm:mt-0 sm:ml-4">
              <inertia-link class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('participants.create')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter un nouveau document
              </inertia-link>
            </div>
          </div>
           
          <div class="mt-3 sm:mt-0 sm:ml-4">
            <!-- <a class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('participants.export')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Exporter la liste des participants en Excel
            </a> -->
            <!-- <button @click="exportParticipants()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" >
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4" viewBox="0 0 16 16">
                <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
              </svg>
               Exporter la liste des participants en Excel
            </button> -->
          </div>
        </div>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              
              <div class="flex ">

                

                <div class="w-1/4 mr-3">
                  <div class="pb-4">
                    <div class="mt-1 relative rounded-md z-10">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                      </div>
                      <input v-model="form.search" type="text" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher">
                    </div>
                  </div>
                </div>

                <div class="w-1/4 mr-3">
                  <div class="pb-4">
                    <div class="mt-1 relative rounded-md z-10">
                      
                      <VueMultiselect
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        v-model="form.company"
                        :multiple="false"
                        placeholder="Selectionner une catégorie"
                        open-direction="bottom"
                        :option-height="200"
                        track-by="id"
                        label="name"
                        :options="companies">
                      </VueMultiselect>

                    </div>
                  </div>
                </div>

                <div class="w-1/4 mr-3">
                  <div class="pb-4">
                    <div class="mt-1 relative rounded-md z-10">
                      
                      <VueMultiselect
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        v-model="form.event"
                        :multiple="false"
                        placeholder="Selectionner un évènement"
                        open-direction="bottom"
                        :option-height="200"
                        track-by="id"
                        label="name"
                        :options="events">
                      </VueMultiselect>

                    </div>
                  </div>
                </div>

                <div class="w-1/4">
                  <div class="pb-4">
                    <div class="mt-1 relative rounded-md z-10">
                      
                      <VueMultiselect
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        v-model="form.confirm"
                        :multiple="false"
                        placeholder="Confirmé"
                        open-direction="bottom"
                        :option-height="100"
                        :options="['Oui','Non']">
                      </VueMultiselect>

                    </div>
                  </div>
                </div>
              </div> 

              <div class="flex mb-4">
                <div class="bg-white p-6 mr-2 flex-1 border-b-2 border-gray-200 shadow">
                  <p class="text-center text-indigo-700">
                    <span class="">{{total_participant}}</span> <br>
                    <span>Nombre de documents</span>
                  </p>
                  
                </div>
                <div class="bg-white p-6 mr-2 flex-1 border-b-2 border-gray-200 shadow">

                  <p class="text-center text-red-300">
                    <span class="">{{total_refused}}</span> <br>
                    <span>Nombre de groupes</span>
                  </p>
                  
                </div>
                <div class="bg-white p-6 mr-2 flex-1 border-b-2 border-gray-200 shadow">

                  <p class="text-center text-green-300">
                    <span class="">{{total_confirmed}}</span> <br>
                    <span>Nombre d'invitations'</span>
                  </p>
                  
                </div>
                <!-- <div class="bg-white p-6 mr-2 flex-1 border-b-2 border-gray-200 shadow">

                  <p class="text-center text-gray-500	">
                    <span class="">{{total_not_confirmed}}</span> <br>
                    <span>Nombre de sans-réponse</span>
                  </p>
                  
                </div>
                <div class="bg-white  p-6 flex-1 border-b-2 border-gray-200 shadow">
                  <p class="text-center text-green-500">
                    <span class="">{{total_present}}</span> <br>
                    <span>Nombre de présents</span>
                  </p>
                  
                </div> -->
              </div> 

              <div class="shadow border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 ">
                  <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          <input v-model="all_partitipant" @change="selectAllParticipant()" type="checkbox" class="h-4 w-4 border-gray-300 rounded focus:ring-indigo-500 text-indigo-500">
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Titre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Catégorie
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Auteur
                        </th>
                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Test PCR
                        </th> -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Preview
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Télecharger
                            
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Lire
                        </th>
                        
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Odd row -->
                    <tr v-for="participant in participants.data" :key="participant.id" class="bg-white">
                      
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <input id="is_admin" @change="selectParticipant(participant)" v-model="participant.selected"  type="checkbox" class="h-4 w-4 border-gray-300 rounded focus:ring-indigo-500 text-indigo-500">
                      </td>
                      <td v-if="list_selected.length===0" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                        <!-- <button class="outline-none text-indigo-600 hover:text-indigo-900" style="display: inline" type="button" @click="sendTicket(participant)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                          </svg>
                        </button> -->
                        <a  v-if="list_selected.length===0" class="outline-none text-indigo-600 hover:text-indigo-900" :href="participant.ticket" style="display: inline" target="_blank">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                          </svg>
                        </a>
                        <!-- <button v-if="list_selected.length===0" class="outline-none text-indigo-600 hover:text-indigo-900" style="display: inline" type="button" @click="sendMail(participant.id)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                          </svg>
                        </button>
                        <button v-if="list_selected.length===0" class="outline-none text-indigo-600 hover:text-indigo-900" style="display: inline" type="button" @click="sendSms(participant.id)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                          </svg>
                        </button> -->
                        <inertia-link v-if="list_selected.length===0" class="outline-none text-indigo-600 hover:text-indigo-900" :href="route('participants.edit', participant.id)" style="display: inline">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                          </svg>
                        </inertia-link>
                        <button v-if="list_selected.length===0" :loading="sending" class="outline-none text-indigo-600 hover:text-indigo-900" style="display: inline" type="button" @click="destroy(participant.id)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.person?.last_name}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.person?.first_name}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.company.name}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.event.name}}
                      </td>
                      <!-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.about_covid==='Test PCR' ? 'X ': ''}}
                      </td> -->
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{participant.about_covid==='Vacciné' ? 'X' : ''}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ participant.created_at}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ participant.refused}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ participant.confirm}}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ participant.present}}
                      </td>

                    </tr>
                    <tr v-if="participants.data.length === 0">
                      <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium" colspan="14">Pas de document.</td>
                    </tr>
                  </tbody>
                </table>
                <div class="px-3 py-4 bg-gray-100 border-t border-gray-200 flex justify-start items-center">
                  <button v-if="list_selected.length != 0" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="sendMails()" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                      <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span class="self-center uppercase">envoyer mail invitation</span>
                  </button>

                  <button v-if="list_selected.length != 0" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="sendManySMS()" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span class="self-center uppercase">envoyer sms invitation</span>
                  </button>

                  <button v-if="list_selected.length != 0" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="sendManyTicket()" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                      <polyline points="9 11 12 14 22 4"></polyline>
                      <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <span class="self-center uppercase">envoyer le ticket d'entree code (qr)</span>
                  </button>

                  <a :href="list_selected[0].ticket" v-if="list_selected.length == 1" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline">
                      <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                      <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    <span class="self-center uppercase">voir qr code</span>
                  </a>

                </div>
              </div>
              <br>
              
              <div class="w-1/4 mr-3">
                <div class="pb-4">
                  <div class="mt-1 relative rounded-md z-10">
                    <input type="checkbox" name="masculin" value="masculin" id="">
                  </div>
                </div>
              </div>
              
              <pagination class="w-3/4" :links="participants.links"/>
            </div>
          </div>
        </div>

        <confirmation-dialog 
          v-if="showModal"
          :message="message"
          :title="title"
          :show="show"
          :closeable="closeable"
          @confirm="confirm()"/>
        <loading v-model:active="sending"
          :can-cancel="false"
          :is-full-page="true"/>
      </div>
    </div>
  </div>    

</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Shared/Pagination'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import ConfirmationDialog from '@/Shared/ConfirmationDialog'
import Loading from 'vue-loading-overlay';
import JetButton from '@/Jetstream/Button'
import 'vue-loading-overlay/dist/vue-loading.css';
import VueMultiselect from 'vue-multiselect'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  created () {
    //console.log(this.filters)
    //console.log(this.participants)
    //console.log(this.total_participant)
    
  },
  components: {
    Pagination,
    ConfirmationDialog,
    Loading,
    JetButton,
    VueMultiselect,
    LoadingButton
  },
  layout: AppLayout,
  props: {
    participants: Object,
    companies: Array,
    events: Array,
    total_participant: Number,
    total_confirmed: Number,
    total_not_confirmed: Number,
    total_refused: Number,
    total_present: Number,
    // file: String,
    filters: Object
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        company: this.filters.company,
        confirm: this.filters.confirm,
        event: this.filters.event,
        pagination: this.filters.pagination
      },
      message: null,
      title: null,
      show:{
			  default: true
		  },
      closeable:{
        default: true
      },
      showModal: false,
      itemDeleteId : null,
      sms_participant_id: null,
      mail_participant_id: null,
      many_sms: false,
      many_mail: false,
      many_ticket: false,
      sending : false,
      list_selected: [],
      participant: null,
      all_partitipant:false
    }
  },
  methods: {
    
    destroy(id) {
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = id
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_ticket = false
      this.title = 'Confirmation de suppression'
      this.message = 'Êtes-vous sûr de vouloir supprimer ce participant?'
    },
    confirm(){
      if(this.itemDeleteId){
        this.showModal = false
        this.$inertia.delete(this.route('participants.destroy', this.itemDeleteId));
      }else{
        if(this.sms_participant_id){
          this.showModal = false
          let form =  {
            participant_id: this.sms_participant_id
          }
          this.$inertia.post(this.route('participants.send.sms'), form, {
              onStart: () => this.sending = true,
              onFinish: () => this.sending = false,
          })
        }else{
          if(this.mail_participant_id){
            this.showModal = false
            let form =  {
              participant_id: this.mail_participant_id
            }
            this.$inertia.post(this.route('participants.send.mail'), form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
          }else{
            if(this.many_sms){
                let form = {
                  participant_list:this.list_selected
                }

                this.$inertia.post(this.route('participants.send.sms.selected.participants'), form, {
                  onStart: () => this.sending = true,
                  onFinish: () => this.sending = false,
                })
                this.list_selected = []
                this.showModal = false
                //console.log('sms')
            }else{
              if(this.many_mail){
                let form = {
                  participant_list:this.list_selected
                }
                this.$inertia.post(this.route('participants.send.mail.selected.participants'), form, {
                  onStart: () => this.sending = true,
                  onFinish: () => this.sending = false,
                })
                this.showModal = false
                this.list_selected = []
              }else{
                if(this.participant){
                  let form = {
                    participant_id: this.participant.id
                  }
                  this.$inertia.post(this.route('participants.send.ticket'), form, {
                    onStart: () => this.sending = true,
                    onFinish: () => this.sending = false,
                  })
                  this.showModal = false
                }else{
                  if(this.many_ticket){
                    let form = {
                      participant_list:this.list_selected
                    }
                    this.$inertia.post(this.route('participants.send.tickets'), form, {
                      onStart: () => this.sending = true,
                      onFinish: () => this.sending = false,
                    })
                    this.showModal = false
                    this.list_selected = []
                  }
                }
              }
            }
          }
        }
      }
      
    },
    cancel(){
      this.showModal = false
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_sms = false
      this.many_mail = false
      this.many_ticket = false
      this.participant = null
    },
    sendMail(id)
    {
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = id
      this.many_sms = false
      this.many_mail = false
      this.many_ticket = false
      this.participant = null
      this.title = 'Confirmation d\'envoi de mail'
      this.message = 'Voulez-vous ré-envoyer l’invitation par e-mails ?'
      
    },
    sendSms(id)
    {
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = id
      this.mail_participant_id = null
      this.many_sms = false
      this.many_mail = false
      this.many_ticket = false
      this.title = 'Confirmation d\'envoi de sms'
      this.message = 'Voulez-vous ré-envoyer l’invitation par SMS ?'
      this.participant = null

    },
    selectParticipant(participant)
    {
      if(this.list_selected.length===0)
      {
        this.list_selected.push(participant)
      }else{

        let list_selected = this.list_selected
        this.list_selected = []
        list_selected.forEach(element => {
          if(element.selected)
            this.list_selected.push(element)
        })
        if(participant.selected)
          this.list_selected.push(participant)
      }
      //console.log(this.list_selected)
    },
    sendMails()
    {
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_sms = false
      this.many_mail = true
      this.many_ticket = false
      this.participant = null
      this.title = 'Confirmation d\'envoi de sms'
      this.message = 'Voulez-vous ré-envoyer les invitations par mails ?'
    },
    sendManySMS()
    {
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_sms = true
      this.many_mail = false
      this.many_ticket = false
      this.participant = null
      this.title = 'Confirmation d\'envoi de sms'
      this.message = 'Voulez-vous ré-envoyer les invitations par SMS ?'

    },
    sendTicket(participant){
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_sms = false
      this.many_mail = false
      this.many_ticket = false
      this.participant = participant
      this.title = 'Confirmation d\'envoi de ticket'
      this.message = 'Voulez vous envoyer ou ré-envoyer le ticket à ce participant ?'
      // if(participant.confirm){

      // }else{
      //   this.$toast.show( "Le participant selectionner n'a pas confirmé sa participation à l'évènement.",{
      //     position: "top-right",
      //     type: 'error',

      //   })
      // }
    },
    selectAllParticipant(){
      if(this.all_partitipant){
        this.list_selected = []
        this.participants.data.forEach(participant => {
          participant.selected = true 
          this.list_selected.push(participant)
        });
      }else{
        this.list_selected = []
        this.participants.data.forEach(participant => {
          participant.selected = false 
        });
      }
      
    },
    sendManyTicket(){
      this.showModal = true
      this.show.default = true
      this.itemDeleteId = null
      this.sms_participant_id = null
      this.mail_participant_id = null
      this.many_sms = false
      this.many_mail = false
      this.many_ticket = true
      this.participant = null
      this.title = 'Confirmation d\'envoi de ticket'
      this.message = 'Voulez-vous ré-envoyer les tickets?'
    },
    exportParticipants() {
      window.location = route('participants.export.list')
    }
    
  },

  computed: {

    totalConfirmed(){
      let nbr = 0;
      for (let index = 0; index < this.participants.data.length; index++) {
        const element = this.participants.data[index];
        if(element.confirm && !element.refused)
          nbr = nbr +1
      }
      return nbr
    },
    totalRefused(){
      let nbr = 0;
      for (let index = 0; index < this.participants.data.length; index++) {
        const element = this.participants.data[index];
        if(element.refused)
          nbr = nbr +1
      }
      return nbr
    },totalConfirmed(){
      let nbr = 0;
      for (let index = 0; index < this.participants.data.length; index++) {
        const element = this.participants.data[index];
        if(element.confirm)
          nbr = nbr +1
      }
      return nbr
    },
    totalNotConfirmed(){
      let nbr = 0;
      for (let index = 0; index < this.participants.data.length; index++) {
        const element = this.participants.data[index];
        if(!element.confirm  && !element.refused)
          nbr = nbr +1
      }
      return nbr
    },
    totalPresent(){
      let nbr = 0;
      for (let index = 0; index < this.participants.data.length; index++) {
        const element = this.participants.data[index];
        if(element.present)
          nbr = nbr +1
      }
      return nbr
    }
  },
  
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.get(this.route('participants.index', Object.keys(query).length ? query : { remember: 'forget'}), {}, { preserveState: true })
      }, 150),
      deep: true,
    },
  },

  mounted(){
    if(this.form.event===null){
      this.events.forEach(event => {
        if(event.status==='In Progress')
          this.form.event = event
      });
    }
    
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>