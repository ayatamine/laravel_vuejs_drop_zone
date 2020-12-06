<template>
    <div class="container  col-6 p-3 bg-white">
         <div class="uploader-container"
         @dragenter.prevent="onDragEnter"
         @dragleave.prevent="onDragLeave"
         @dragover.prevent
         @drop.prevent.stop="onDrop"
         :class="{dragging:isDragging}"
         >
             <div class="uploader-top" v-show="images.length">
                 <label for="file">اضف المزيد</label>
                 <button class="btn" @click.prevent="upload">رفع</button>
             </div>
             <div v-show="!images.length">
                 <i class="fa fa-cloud-upload-alt"></i>
                 <p>قم بسحب أو افلات الصور</p>
                 <div>أو</div>
                 <div class="file-input">
                     <label for="file">اختر الملف</label>
                     <input type="file" name="file" multiple @change.prevent="onImageChanged" id="file">
                 </div>
             </div>
             <div class="image-preview" v-show="images.length">
                 <div class="image-wrapper " v-for="(image,i) in images" :key="i">
                     <img :src="image" :alt='`image ${i}`'>
                     <div class="details">
                         <span class="name" v-text="files[i].name"></span>
                         <span class="size" v-text="files[i].size+' kb'"></span>
                     </div>
                 </div>

             </div>
         </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                isDragging:false,
                counter:0,
                files:[],
                images:[]
            }
        },
        methods:{
            onImageChanged(e){
               const files = e.target.files;
               Array.from(files).forEach(file => this.addImage(file))
            },
            onDragEnter(){
                  this.isDragging = true;
                  this.counter++;
            },
            onDragLeave(){

                  this.counter--;
                  if(this.counter <=0){
                      this.isDragging = false;
                  }
            },
            onDrop(e){
             this.isDragging = false;
               const files = e.dataTransfer.files;
               Array.from(files).forEach(file => this.addImage(file))

            },
            addImage(file){
                if(!file.type.match('image.*')){
                    console.log(`الملف ${file.type} لايحترم الصيغة`);
                    return ;
                }
                this.files.push(file); //upload
                //preview of image
                const reader = new FileReader();
                reader.onload = (e)=>this.images.push(e.target.result)
                reader.readAsDataURL(file);


            },
            upload(){
               const fdata = new FormData();
               this.files.forEach(file =>{
                   fdata.append('images[]',file,file.name);
               })
               axios.post('/image-upload',fdata)
               .then(response =>{
                   alert(response.data.message);
                   this.images = [];
                   this.files = [];
               })
            }
        }
    }
</script>
<style lang="scss" scoped>
  .uploader-container{
      background: rgb(240,240,240);
    text-align: center;
    font-size: 22px;
    border: 3px dashed #a2a2a2;
    padding: 1rem 2rem;
    position: relative;
    color: #797979;
    &.dragging{
        background: #fff;
        color: #797979;
        border:3px dashed #1adf65;
        .file-input label{
            background: #909090;
            color:#fff;
        }
    }
    i{
            font-size: 2rem;
    margin-bottom: 1rem;
    }
    .file-input{
        width: 250px;
        margin: auto;
        height: 71px;
        position: relative;
        input,label{
                background: #fff;
                color: #0c66d6;
                padding: 0.5rem;
                position: absolute;
                margin-top: 10px;
                left: 0;
                top: 0;
                width: 100%;
                cursor: pointer;
                border-radius: 5px;
                box-shadow: 0px 1px 4px #797979;
        }
        input{
            opacity: 0;
            z-index: -2;
        }
    }
    .image-preview{
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
        margin-top: 4rem;
        .image-wrapper{

        display: flex;
        flex-direction: column;
        width: 30%;
        height: 190px;
        background: #fff;
        color: #000;
        justify-content: space-between;
        align-items: self-start;
        padding: 3px;
        margin-bottom: 2rem;
        box-shadow: 1px 0px 10px snow;
        img{
            width:100%;
            height:60%;
        }
         .details{
                 display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: self-start;
                padding-left: 0.5rem;
                font-size: 0.8rem;
                font-weight: bold;
                .name{
                        word-break: break-all;
                }
         }
        }
    }
    .uploader-top{
            text-align: right;
            background: #fff;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            font-size: 16px;
            label,button{
                    background: #3c78e4;
                    color: #fff;
                    padding: 0 5px;
                    border-radius: 4px;
                    margin: 0 2px;
                    cursor: pointer;
            }
    }

  }
</style>
