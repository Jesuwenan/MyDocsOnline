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
                            <inertia-link
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :href="route('documents.create')">
                                Ajouter un nouveau document
                            </inertia-link>
                        </div>
                    </div>
                    <div v-show="fullScreenModalIsOpen">
                        <full-screen-modal @closeFullSreenModal='closeFullSreenModal()' :is-open="fullScreenModalIsOpen">
                            <template #content>
                                    
                                    <div class="w-86 bg-white sm:p-6 border-2 rounded-lg ">        
                                        <h3 class="text-xl font-extrabold mb-4 text-gray-700">Partager:</h3>                               
                                        <div class="block mt-3 col-span-12 sm:col-span-6">
                                        <div class="inline m-2">
                                            
                                            <input value="groupe" v-model="selected"  id="selected" name="selected" type="radio" class="ml-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                            <label for="group" class="ml-1 text-sm font-medium text-gray-700">
                                                Partager dans un groupe
                                            </label>
                                        </div>
                                        <div class="inline m-2">
                                            
                                            <input value="user" v-model="selected" id="selected" name="selected" type="radio" class="focus:ring-green-500 ml-1 h-4 w-4 text-green-600 border-gray-300">
                                            <label for="user" class="ml-1 text-sm font-medium text-gray-700">
                                                Partager à un utilisateur
                                            </label>
                                        </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6" v-show="selected === 'user'">
                                        <form @submit.prevent="submit">
                                            
                                            <VueMultiselect
                                            class="mt-1 mb-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            v-model="user_to_share_document" 
                                            :multiple="false"
                                            label = "username"
                                            track-by = 'id'  
                                            placeholder="Utilisateur"
                                            open-direction="bottom"
                                            :option-height="100"
                                            :options="persons">
                                            </VueMultiselect>
                                            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Partager
                                            </button>
                                        </form>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6" v-show="selected === 'groupe'">
                                        <form @submit.prevent="submit" v-show="selected === 'groupe'">
                                            
                                            <VueMultiselect
                                            class="mt-1 mb-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            v-model="group_to_share_document" 
                                            :multiple="false"
                                            label = "group_name"
                                            track-by = 'id'
                                            placeholder="Groupes" 
                                            open-direction="bottom"
                                            :option-height="100"
                                            :options="groupes">
                                            </VueMultiselect>
                                            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Partager
                                            </button>
                                        </form>
                                        </div>
                                        </div>
                                    
                            </template>
                        </full-screen-modal>
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-4">
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
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <input v-model="form.search" type="text"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                                placeholder="Rechercher">
                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/4 mr-3">
                                    <div class="pb-4">
                                        <div class="mt-1 relative rounded-md z-10">

                                            <!-- <VueMultiselect
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                v-model="form.company" :multiple="false"
                                                placeholder="Selectionner une catégorie" open-direction="bottom"
                                                :option-height="200" track-by="id" label="name" :options="document">
                                            </VueMultiselect> -->

                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/4 mr-3">
                                    <div class="pb-4">
                                        <div class="mt-1 relative rounded-md z-10">

                                            <!-- <VueMultiselect
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                v-model="form.event" :multiple="false"
                                                placeholder="Selectionner un évènement" open-direction="bottom"
                                                :option-height="200" track-by="id" label="name" :options="events">
                                            </VueMultiselect> -->

                                        </div>
                                    </div>
                                </div>

                            <div class="w-1/4">
                                    <div class="pb-4">
                                        <div class="mt-1 relative rounded-md z-10">

                                            <!-- <VueMultiselect
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                v-model="form.confirm" :multiple="false" placeholder="Confirmé"
                                                open-direction="bottom" :option-height="100" :options="['Oui', 'Non']">
                                            </VueMultiselect> -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                                <!-- {{ documents}} -->
                            <div class="shadow border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input v-model="all_partitipant" @change="selectAllParticipant()"
                                                    type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded focus:ring-indigo-500 text-indigo-500">
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Titre
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Auteur
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Categorie
                                            </th>
                                    
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>

                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description
                                            </th>

                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Télecharger
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Lire
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Partager
                                            </th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr v-for="document in documents" :key="document.id"
                                            class="bg-white">

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <input id="is_admin" type="checkbox"
                                                    class="h-4 w-4 border-gray-300 rounded focus:ring-indigo-500 text-indigo-500">
                                            </td>
                                            <td v-if="list_selected.length === 0"
                                                class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                    <inertia-link v-if="list_selected.length === 0"
                                                        class="outline-none text-indigo-600 hover:text-indigo-900"
                                                        :href="route('documents.edit', document.id)"
                                                        style="display: inline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            style="display: inline">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </inertia-link>
                                                    <button v-if="list_selected.length === 0" :loading="sending"
                                                        class="outline-none text-indigo-600 hover:text-indigo-900"
                                                        style="display: inline" type="button"
                                                        @click="destroy(document.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            style="display: inline">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                    
                                                    <button :loading="sending"
                                                    class="outline-none text-indigo-600 align-middle hover:text-indigo-900"
                                                    style="display: inline" type="button"
                                                    @click="read(document.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke=" CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                    </button>
                                                    <button :loading="sending"
                                                    class="outline-none text-indigo-600 align-middle hover:text-indigo-900"
                                                    style="display: inline" type="button"
                                                    @click="showShareFormDocument(document.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>    
                                                    </button>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ document.titre }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ document.auteur }}
                                            </td>
                                            
                                    
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ document.categorie.name }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ document.date }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ document.description }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <button :loading="sending"
                                                    class="outline-none text-indigo-600 hover:text-indigo-900 center"
                                                    style="display: inline" type="button"
                                                    @click="read(document.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#2563EB" stroke="#fff" stroke-width="2" 
                                                    stroke-linecap="round" stroke-linejoin="round"><path fill="#2563EB" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle fill="#2563EB" cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <button v-if="list_selected.length === 0" :loading="sending"
                                                    class="outline-none text-indigo-600 hover:text-indigo-900"
                                                    style="display: inline" type="button"
                                                    @click="showShareFormDocument(document.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#2563EB" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle fill="#2563EB" cx="18" cy="5" r="3"></circle><circle fill="#2563EB" cx="6" cy="12" r="3"></circle><circle fill="#2563EB" cx="18" cy="19" r="3"></circle><line fill="#2563EB" x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line fill="#2563EB" x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                                </button>
                                            </td>

                                            
                                        </tr>
                                        <tr v-if="documents.length === 0">
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"
                                                colspan="14">Pas de document.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div
                                    class="px-3 py-4 bg-gray-100 border-t border-gray-200 flex justify-start items-center">


                                </div>
                            </div>
                            <br>

                            <!-- <pagination class="w-3/4" :links="participants.links" /> -->
                        </div>
                    </div>
                </div>

                <confirmation-dialog v-if="showModal" :message="message" :title="title" :show="show"
                    :closeable="closeable" @confirm="confirm()" />
                <loading v-model:active="sending" :can-cancel="false" :is-full-page="true" />
            </div>
        </div>
    </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Shared/Pagination'
import FullScreenModal from '@/Shared/FullScreenModal'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import ConfirmationDialog from '@/Shared/ConfirmationDialog'
import Loading from 'vue-loading-overlay';
import JetButton from '@/Jetstream/Button'
import 'vue-loading-overlay/dist/vue-loading.css';
import VueMultiselect from 'vue-multiselect'
import LoadingButton from '@/Shared/LoadingButton'

export default {
    created() {
        //console.log(this.filters)
        //console.log(this.participants)
        //console.log(this.total_participant)

    },
    components: {
        Pagination,
        ConfirmationDialog,
        FullScreenModal,
        Loading,
        JetButton,
        VueMultiselect,
        LoadingButton
    },
    layout: AppLayout,
    props: {
        documents: Object,
        persons: Object,
        groupes: Object
    },
    data() {
        return {
            selected: 'user',
            document: '',
            document_id: null,
            group_id:null,
            user_to_share_document: null,
            person_id: null,
            form: {
                },
            
            user_form: {
                username: null,
                document: null,
                },

            group_form: {
                group_id: null
                },
            message: null,
            title: null,
            show: {
                default: true
            },
            closeable: {
                default: true
            },
            showModal: false,
            fullScreenModalIsOpen: false,
            itemDeleteId: null,
            sending: false,
            list_selected: [],
        }
    },
    methods: {

        destroy(id) {
            this.showModal = true
            this.show.default = true
            this.itemDeleteId = id
            this.title = 'Confirmation de suppression'
            this.message = 'Êtes-vous sûr de vouloir supprimer ce document?'
        },

        closeFullSreenModal(){
            this.fullScreenModalIsOpen = false
        },

        showShareFormDocument(id){
            this.fullScreenModalIsOpen = true
            this.document_id = id
        },
        
        submit() {
            // console.log(this.document_id);
            let form = {
                document_id: this.document_id,
                user_id: this.user_to_share_document?.id,
                group_id: this.group_to_share_document?.id
            }
            
            this.$inertia.post(this.route('documents.share'), form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false  
            })
            
        },        

        read(id) {
            
        },

        download(id) {
            
        },

        confirm(id) {
                this.id = id
                this.showModal = false
                this.$inertia.delete(this.route('documents.destroy', this.itemDeleteId));
            
        },

        selectParticipant(participant) {
            if (this.list_selected.length === 0) {
                this.list_selected.push(participant)
            } else {

                let list_selected = this.list_selected
                this.list_selected = []
                list_selected.forEach(element => {
                    if (element.selected)
                        this.list_selected.push(element)
                })
                if (participant.selected)
                    this.list_selected.push(participant)
            }
            //console.log(this.list_selected)
        },
    },

    computed: {

        totalConfirmed() {
            let nbr = 0;
            for (let index = 0; index < this.participants.data.length; index++) {
                const element = this.participants.data[index];
                if (element.confirm && !element.refused)
                    nbr = nbr + 1
            }
            return nbr
        },
        totalRefused() {
            let nbr = 0;
            for (let index = 0; index < this.participants.data.length; index++) {
                const element = this.participants.data[index];
                if (element.refused)
                    nbr = nbr + 1
            }
            return nbr
        }, totalConfirmed() {
            let nbr = 0;
            for (let index = 0; index < this.participants.data.length; index++) {
                const element = this.participants.data[index];
                if (element.confirm)
                    nbr = nbr + 1
            }
            return nbr
        },
        totalNotConfirmed() {
            let nbr = 0;
            for (let index = 0; index < this.participants.data.length; index++) {
                const element = this.participants.data[index];
                if (!element.confirm && !element.refused)
                    nbr = nbr + 1
            }
            return nbr
        },
        totalPresent() {
            let nbr = 0;
            for (let index = 0; index < this.participants.data.length; index++) {
                const element = this.participants.data[index];
                if (element.present)
                    nbr = nbr + 1
            }
            return nbr
        }
    },

    watch: {

        },

    mounted() {
        if (this.form.event === null) {
            this.events.forEach(event => {
                if (event.status === 'In Progress')
                    this.form.event = event
            });
        }

    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css">
</style>