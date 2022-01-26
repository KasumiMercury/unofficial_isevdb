<template>
	<modal name="edit_modal" height="auto" >
        <div class="text-center m-3">
            <template v-if="status == 0">
                <b-form-group label="報告内容/削除申請を選択してください" v-slot="{ ariaDescribedby }">
                    <b-form-radio v-model="newStatus" :aria-describedby="ariaDescribedby" name="Status_edit" value="1">メン限</b-form-radio>
                    <b-form-radio v-model="newStatus" :aria-describedby="ariaDescribedby" name="Status_edit" value="2">非公開</b-form-radio>
                    <b-form-radio v-model="newStatus" :aria-describedby="ariaDescribedby" name="Status_edit" value="3">DBから削除</b-form-radio>
                </b-form-group>
            </template>
            <template v-else>
                <b-form-group label="報告内容/削除申請を選択してください" v-slot="{ ariaDescribedby }">
                    <b-form-radio v-model="newStatus" :aria-describedby="ariaDescribedby" name="Status_edit" value="2">非公開</b-form-radio>
                    <b-form-radio v-model="newStatus" :aria-describedby="ariaDescribedby" name="Status_edit" value="3">DBから削除</b-form-radio>
                </b-form-group>
            </template>
            <div v-if="newStatus == 3" class="m-5">
                <b-form-input v-model="CreaterName" placeholder="登録時のHNを入力"></b-form-input>
            </div>
            <div class="m-3">
                <b-button v-if="newStatus == 1" @click="editStatus">メン限報告で確定</b-button>
                <b-button v-if="newStatus == 2" @click="editStatus">非公開報告で確定</b-button>
                <b-button v-if="newStatus == 3" @click="editStatus"  v-bind:disabled="activeBtn">削除申請をする</b-button>
            </div>
            <div v-if="newStatus == 3" class="m-3">
                <p>登録したハンドルネームを忘れた場合は管理人にTwitterのリプライにて連絡してください。</p>
            </div>
            <div class="m-3">
                <b-button @click="hide">戻る</b-button>
            </div>
        </div>
	</modal>
</template>
<script>
export default {
    props: ['id','status','player'],
	data(){
        return{
            newStatus: 0,
            CreaterName:""
        }
    },
    methods: {
        editStatus(){
            const params = new FormData();
            params.append('status', this.newStatus)
			
            axios.post('/api/root/edit/'+this.id, 
            params,
            {
            headers: {
                'content-type': 'multipart/form-data',
                'X-HTTP-Method-Override': 'PUT',
            }
        })
        .then(response => this.users.unshift(response.data))
        .catch(error => console.log(error));
            this.$emit('from-child2');
        },
		hide() {
            this.$emit('from-child')
		},
    },
    computed:{
            activeBtn() {
        if (this.CreaterName == '') {
            return true;
        } else if (this.CreaterName == "root") {
            return false;
        } else if (this.CreaterName == this.player.CreaterHN) {
            return false;
        } else {
            return true;
        }
        },
    }
}
</script>