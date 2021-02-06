class ProductModel {
    constructor(  
        id,      
        name,
        price,
        stock,
        category_id        
    ){

        this.id = id;
        this.name = name;
        this.price = price;
        this.stock = stock;        
        this.category_id = category_id;        
    }
}

export default ProductModel;