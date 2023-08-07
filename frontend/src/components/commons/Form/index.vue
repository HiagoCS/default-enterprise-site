<template>
    <div class="col-12 form">
        <div v-for="field in inputs" :class="`col-12 field-container ${label_class[field.id]}`">
            <div v-if="field.multifield" v-for="multifield in field.multifield" :class="`row multifield ${label_class[multifield.id]}`">
                <input :type="multifield.type" 
                    v-model="content[multifield.id]"
                    v-mask="multifield.mask"
                    :class="`form-control ${label_class[field.id]}`"
                    :id="multifield.id"
                    @click="content[multifield.id]='';label_class[multifield.id]='active'" 
                    @focusout="content[multifield.id] === '' ? label_class[multifield.id]='' : label_class[multifield.id]='active'"
                    @change="this.$emit('update:content', this.content)"
                >
                <label :for="multifield.id" :style="`font-size:${multifield.font_size}`" :class="label_class[multifield.id]" @focusout="label_class[multifield.id]">{{ multifield.name }}</label>
            </div>
            <input v-if="!field.multifield && field.mask" :type="field.type"  
                v-model="content[field.id]"
                v-mask="field.mask"
                :class="`form-control ${label_class[field.id]}`"
                :id="field.id"
                 @click="content[field.id]='';label_class[field.id]='active'" 
                 @focusout="content[field.id] === '' ? label_class[field.id]='' : label_class[field.id]='active'"
                 @change="this.$emit('update:content', this.content)"
            >
            <input v-if="!field.mask" :type="field.type"  
                v-model="content[field.id]"
                :class="`form-control ${label_class[field.id]}`"
                :id="field.id"
                 @click="content[field.id]='';label_class[field.id]='active'" 
                 @focusout="content[field.id] === '' ? label_class[field.id]='' : label_class[field.id]='active'"
                 @change="this.$emit('update:content', this.content)"
            >
            <label :for="field.id" :class="label_class[field.id]" @focusout="label_class[field.id]">{{ field.name }}</label>
        </div>
    </div>
</template>

<style lang="scss" src="./style.scss" scoped></style>
<script>
export default{
    props:['inputs', 'content'],
    data(){
        return{
            label_class:[]
        }
    }
}
</script>