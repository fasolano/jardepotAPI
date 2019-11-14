import { Pipe, PipeTransform } from '@angular/core';
import * as _ from 'lodash';

@Pipe({
  name: 'orderBy'
})
export class OrderByPipe implements PipeTransform {

  transform(products: Array<any>, $type, $categories){
      switch ($type) {
          case 'relevant':
              return _.orderBy(products, 'name', 'asc');
              break;
          case 'low-high':
              return _.orderBy(products, 'newPrice', 'asc');
              break;
          case 'high-low':
              return _.orderBy(products, 'newPrice', 'desc');
              break;
          default:
              return _.orderBy(products, 'id', 'asc');
              break;
      }

  }

}
