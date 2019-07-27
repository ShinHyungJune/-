class Part {
    static all(then, params = {}){
        return axios.get('/api/parts', {
            params: params
        }).then((response) => {
            then(response.data);
        });
    }

    static show(then, id){
        return axios.get('/api/parts/' + id)
            .then((response) => {
                then(response.data)
            })
            .catch((error) => {
                if(!error.errors)
                    alert(error.message);
            });
    }

    static delete(then, id){
        return axios.delete(`/api/parts/${id}`)
            .then((response) => {
                then(response.data);
            })
            .catch((error) => {
                if(!error.errors)
                    alert(error.message);
            });
    }
}


export default Part;
