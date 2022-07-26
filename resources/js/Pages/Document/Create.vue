<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('documents.index')">Documents</inertia-link>
                        </div>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Créer un document</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white rounded shadow ">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">


                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="titre">Titre *:</label>
                            <input v-model="form.titre" ref="titre" name="titre" id="titre" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.titre" class="text-red-700 mt-2 text-sm">{{ errors.titre }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="auteur">Auteur *:</label>
                            <input v-model="form.auteur" ref="auteur" name="auteur" id="auteur" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.auteur" class="text-red-700 mt-2 text-sm">{{ errors.auteur }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="Categorie">Categorie *:</label>
                            <VueMultiselect
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                v-model="category" 
                                label="nom"
                                track-by="id"
                                @select="categorySelection"
                                :multiple="false" 
                                open-direction="bottom"
                                :option-height="100"
                                :options="categories">
                            </VueMultiselect>
                            <div v-if="errors.category_id" class="text-red-700 mt-2 text-sm">{{ errors.category_id }}</div>
                        </div>
                        
                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="Categorie">Date *:</label>
                            <input v-model="form.date" ref="date" name="date" id="date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="date"  />
                            <div v-if="errors.date" class="text-red-700 mt-2 text-sm">{{ errors.date }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="Categorie">Slug *:</label>
                            <input v-model="form.slug" ref="slug" name="slug" id="slug" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.slug" class="text-red-700 mt-2 text-sm">{{ errors.slug }}</div>
                        </div>

                        <div class="col-span-3 sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700" for="Categorie">Mot de passe *:</label>
                            <input v-model="form.password" ref="password" name="password" id="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="password"  />
                            <div v-if="errors.password" class="text-red-700 mt-2 text-sm">{{ errors.password }}</div>
                        </div>

                        
                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="first_name">Description *:</label>
                            <input v-model="form.description" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.description" class="text-red-700 mt-2 text-sm">{{ errors.description }}</div>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="first_name">Fichier *:</label>
                            <file-pond
                            name="file"
                            ref="pond"
                            label-idle="Cliquer/Glisser et déposer ici votre document..."
                            labelFileProcessingComplete="Effectué"
                            labelFileProcessing="En cours"
                            labelFileLoading="Chargement"
                            labelTapToCancel="Annuler"
                            labelTapToRetry="Réeassayer"
                            labelInvalidField="Fichier invalide"
                            labelTapToUndo="Supprimer"
                            labelMaxFileSizeExceeded="Image trop grande"
                            labelMaxFileSize="La taille maximum est de 200MB"
                            maxFileSize="200MB"
                            v-bind:allow-multiple="false"
                            v-bind:required="false"
                            accepted-file-types="application/pdf,image/jpeg, image/png"
                            server="/filepond/api/process"
                            v-on:init="handleFilePondInit"
                            :allowBrowse="true"
                            :allowFileEncode="true"
                            :captureMethod="null"
                            @processfile="processFile"
                            @removefile="removeFile"
                            @addfile="addFile"/>
                        </div>
                        
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Enregistrer</loading-button>
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
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond-plugin-image-pdf-overlay/dist/filepond-plugin-image-overlay.min.css';
import FilePondPluginImageOverlay from 'filepond-plugin-image-pdf-overlay';
import 'filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css';
import FilePondPluginGetFile from 'filepond-plugin-get-file';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";
// import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
// import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImageOverlay,
    FilePondPluginGetFile,
    FilePondPluginFileValidateSize,
    FilePondPluginPdfPreview,
);
export default {
    
    components: {
        LoadingButton,
        TextInput,
        SelectInput, 
        VueMultiselect,
        VueTelInput,
        FilePond       
    },
    props: {
        people: Array,
        categories: Object,
        errors: Object,
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            category:null,
            form: {
                titre: null,
                auteur: null,
                category_id: null,
                date: null,
                slug: null,
                password: null,
                description: null,
                titre: null,
                files: [],
            },
            inputOptions:{
                placeholder:'Entrez votre n° de téléphone'
            },
            phone: null,
            selected: null,
            autocomplete: null,
            currentTab : 'details',
            files: new Map(),
        }
    },
    
    methods: {
        
        categorySelection(data){
            this.form.category_id = data.id
            this.category = data
        },
        submit() {
            
            Object.entries(this.files).map(serverId => this.form.files.push(f.serverId));
            
            this.$inertia.post(this.route('documents.store'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
        },
        processFile(e, f) {
            this.files.set(f.id, f.serverId)
        },
        removeFile: function (e, f) {
            this.files.delete(f.id);
        },
        addFile(e, f) {
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
                        this.form.titre = response.data.person.last_name
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
                    self.form.national_registry = null
                    self.form.person_id = null
                })
                //console.log('search')
            }
            
        },
        onInput(input) {
                axios({
                    method:'post',
                    url:"/api/search-person",
                    data:{
                        phone: this.form.number,
                    },
                }).then((response)=>{
                        //console.log(response.data.status)
                    if(response.data.status){
                        this.form.titre = response.data.person.last_name
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
                    self.form.national_registry = null
                    self.form.person_id = null
                    self.form.email = null
                })
            
        },
        
    },

    computed () {
        handleFilePondInit()
        {
            let files = [];

            for (const file of this.document.files) {
                if(file.uuid !== "undefined" && file.uuid !== undefined)
                {
                    files.push({
                        source: file.uuid,
                        options: {
                            type: 'local'
                        },
                    });
                }
            }

            return files;
        }
    
    },
    mounted () {

        // if(!this.$page.props.user.is_admin)
        // {
        //     this.companySelection(this.$page.props.user.company)
        // }
        
        // this.autocomplete = new google.maps.places.Autocomplete(
        //     /** @type {!HTMLInputElement}*/(this.$refs.address),
        //     { types: ['geocode'] }
        // );
        
        // this.autocomplete.addListener('place_changed', () => {
        //     const place = this.autocomplete.getPlace();
        //     // contient le pays, la ville le code postal, etc...
        //     for (let index = 0; index < place.address_components.length; index++) {
        //         const element = place.address_components[index];
        //         switch (element.types[0]) {
                    
        //             case 'route':
        //                 this.form.address  = element.short_name
        //                 break;
        //             case 'locality':
        //                 this.form.city  = element.long_name
        //                 break;
        //             case 'postal_code':
        //                 this.form.postal_code  = element.long_name
        //                 break;
        //             default:
        //                 break;
        //         }
                
        //     }

        // });
    
    },
    
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>