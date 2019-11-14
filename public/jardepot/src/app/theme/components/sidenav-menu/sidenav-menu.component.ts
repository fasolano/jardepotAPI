import {Component, OnInit, Input} from '@angular/core';
import {SidenavMenuService} from './sidenav-menu.service';
import {AppService} from '../../../app.service';

@Component({
    selector: 'app-sidenav-menu',
    templateUrl: './sidenav-menu.component.html',
    styleUrls: ['./sidenav-menu.component.scss'],
    providers: [SidenavMenuService]
})
export class SidenavMenuComponent implements OnInit {
    @Input('menuItems') menuItems;
    @Input('menuParentId') menuParentId;
    parentMenu: Array<any>;
    menuTopBar: Array<any>;

    constructor(private sidenavMenuService: SidenavMenuService, private appService: AppService) {
    }

    ngOnInit() {
        this.parentMenu = this.menuItems.filter(item => item.parentId == this.menuParentId);
        this.appService.getMenu().subscribe(data => {
            this.menuTopBar = data;
        });
    }

    onClick(menuId) {
        let menuItem = document.getElementById('menu-item-'+menuId);
        if (menuItem.classList.contains('expanded')) {
            this.sidenavMenuService.closeOtherSubMenus();
        } else {
            this.sidenavMenuService.closeOtherSubMenus();
            this.sidenavMenuService.toggleMenuItem(menuId);
        }
    }

    public changeString($string) {
        return $string.replace(/ /g, "-");
    }

}
