import Swal from "sweetalert2";

export const Global = {
    // show error alert
    showErrorAlert(isToast, icon, title, error) {
        var content =
            "<strong><font color='white'>" + title + "</font></strong>";
        Swal.fire({
            toast: isToast,
            position: "top-end",
            icon: icon,
            html: content,
            iconColor: "white",
            showConfirmButton: false,
            timer: 3500,
            background: "red"
        });
        if (error != null) {
            if (error.response.status == 401 || error.response.status == 403) {
                // logout code

                store.dispatch("actionLogout");
            }
        }
    },

    // show success alert
    showSuccessAlert(isToast, icon, title) {
        var content =
            "<strong><font color='white'>" + title + "</font></strong>";
        Swal.fire({
            toast: isToast,
            position: "top-end",
            icon: icon,
            html: content,
            iconColor: "white",
            showConfirmButton: false,
            timer: 3500,
            background: "green"
        });
    },

    // show confirmation alert
    async showConfirmationAlert(title, text, icon) {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        });
    },

    SearchTimeOut: 2000
};
