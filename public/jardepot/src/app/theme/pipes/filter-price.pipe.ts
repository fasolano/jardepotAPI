import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'filterPrice'
})
export class FilterPricePipe implements PipeTransform {

    transform(products: Array<any>, min, max) {
        return products.filter(product => product.newPrice <= max && product.newPrice >= min );
    }

}
