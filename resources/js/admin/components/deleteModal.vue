<template>
    <div>
        <!-- delete alert modal -->
        <Modal
            v-model="getDeleteModalObj.showDeleteModal"
            width="360"
            :mask-closable="false"
            :closable="false"
        >
            <template #header>
                <p style="color: #f60; text-align: center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Confirmation de suppression</span>
                </p>
            </template>
            <div style="text-align: center">
                <p>Voulez-vous vraiment le supprimer</p>
            </div>
            <template #footer>
                <Button type="default" size="large" @click="closeModal">
                    Fermer
                </Button>
                <Button
                    type="error"
                    size="large"
                    :loading="isDeleting"
                    :disabled="isDeleting"
                    @click="deleteReleveur"
                >
                    Supprimer
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isDeleting: false,
        };
    },
    methods: {
        async deleteReleveur() {
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                this.getDeleteModalObj.deleteUrl,
                this.getDeleteModalObj.data
            );
            if (res.status === 200) {
                // this.s(this.getDeleteModalObj.successMsg);
                this.s('La suppression a été effectuée avec succès.');
                this.$store.commit("setDeletingModalObj", {
                  ...this.getDeleteModalObj,
                  showDeleteModal: false,
                  isDeleted: true,
                });
                // this.$store.commit("setDeleteModal", true);
            } else {
                this.swr();
                // this.$store.commit("setDeleteModal", false);
            }
            this.isDeleting = false;
        },
        closeModal() {
          this.$store.commit("setDeletingModalObj", {
            ...this.getDeleteModalObj,
            showDeleteModal: false,
          });
        },
        // closeModal() {
        //     this.$store.commit("setDeleteModal", false);
        // },
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"]),
    },
};
</script>
