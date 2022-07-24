<template>
<div class="hello">
    <h1></h1>
    <select v-if="!bWASM" id="sources"></select>
    <button v-if="!bWASM" @click="acquireImage()">Acquire Images</button>
    <button @click="openImage()">Open Documents</button>
    <br />
    <br />
    <div v-bind:id="containerId"></div>
</div>
</template>

<script>
import Dynamsoft from "dwt";
export default {
    name: "HelloWorld",
    props: {
        msg: String,
    },
    data() {
        return {
            containerId: "dwtControlContainer",
            bWASM: false,
        };
    },
    mounted() {
        this.bWASM = false;
        /**
         * ResourcesPath & ProductKey must be set in order to use the library!
         */
        Dynamsoft.DWT.ResourcesPath = "/dwt-resources";
	Dynamsoft.WebTwainEnv.ProductKey = 'YOUR-PRODUCT-KEY';
        Dynamsoft.DWT.Containers = [{
            WebTwainId: "dwtObject",
            ContainerId: this.containerId,
            Width: "100%",
            Height: "400px",
        }, ];
        Dynamsoft.DWT.RegisterEvent("OnWebTwainReady", () => {
            this.Dynamsoft_OnReady();
        });
        Dynamsoft.DWT.Load();
    },
    methods: {
        /**
         * Dynamsoft_OnReady is called when a WebTwain instance is ready to use.
         * In this callback we do some initialization.
         */
        Dynamsoft_OnReady() {
            this.DWObject = Dynamsoft.DWT.GetWebTwain(this.containerId);
	    this.bWASM = Dynamsoft.Lib.env.bMobile || !Dynamsoft.DWT.UseLocalService;
            if (this.bWASM) {
                this.DWObject.Viewer.cursor = "pointer";
            } else {
                let sources = this.DWObject.GetSourceNames();
                this.selectSources = document.getElementById("sources");
                this.selectSources.options.length = 0;
                for (let i = 0; i < sources.length; i++) {
                    this.selectSources.options.add(new Option(sources[i], i.toString()));
                }
            }
        },
        /**
         * Acquire images from scanners or cameras or local files
         */
        acquireImage() {
            if (!this.DWObject) this.DWObject = Dynamsoft.DWT.GetWebTwain();
            if (this.bWASM) {
                alert("Scanning is not supported under the WASM mode!");
            } else if (
                this.DWObject.SourceCount > 0 &&
                this.DWObject.SelectSourceByIndex(this.selectSources.selectedIndex)
            ) {
                const onAcquireImageSuccess = () => {
                    this.DWObject.CloseSource();
                };
                const onAcquireImageFailure = onAcquireImageSuccess;
                this.DWObject.OpenSource();
                this.DWObject.AcquireImage({},
                    onAcquireImageSuccess,
                    onAcquireImageFailure
                );
            } else {
                alert("No Source Available!");
            }
        },
        /**
         * Open local images.
         */
        openImage() {
            if (!this.DWObject) this.DWObject = Dynamsoft.DWT.GetWebTwain();
            this.DWObject.IfShowFileDialog = true;
            /**
             * Note:
	     * This following line of code uses the PDF Rasterizer which is an extra add-on that is licensed seperately
             */
            this.DWObject.Addon.PDF.SetConvertMode(
                Dynamsoft.DWT.EnumDWT_ConvertMode.CM_RENDERALL
            );
            this.DWObject.LoadImageEx(
                "",
                Dynamsoft.DWT.EnumDWT_ImageType.IT_ALL,
                () => {
                    //success
                },
                () => {
                    //failure
                }
            );
        },
    },
};
</script>
