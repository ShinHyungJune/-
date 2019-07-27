export default {
    methods: {
        removeItem(items, item){
            let index = items.findIndex(data => {
                return data.id === item.id
            });

            items.splice(index, 1);

            return items;
        },

        addItem(items, item){
            items.push(item);

            return items;
        },

        updateItem(items, item){
            let index = items.findIndex(data => {
                return data.id === item.id
            });

            console.log(index);

            items.splice(index, 1, item);

            console.log(items[0].name);

            return items;
        }
    }
};
