export class Category {
  constructor(public id: number,
              public name:string,
              public hasSubCategory: boolean,
              public parentId: number) { }
}

export class Product {
  constructor(public id: number,
              public name: string,
              public images: Array<any>,
              public oldPrice: number,
              public newPrice: number,
              public discount: number,
              public description: string,
              public availibilityCount: number,
              public brand: string,
              public mpn: string,
              public productType: string,
              public dataSheet: string,
              public metaDescription: string,
              public idSeccion: number,
              public cartCount: number) { }
}
