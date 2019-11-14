import {Component, OnInit, Input} from '@angular/core';
import { faWhatsapp } from '@fortawesome/free-brands-svg-icons';
import {AppService} from '../../../app.service';

@Component({
    selector: 'app-menu',
    templateUrl: './menu.component.html',
    styleUrls: ['./menu.component.scss']
})
export class MenuComponent implements OnInit {
    faWhatsapp = faWhatsapp;

    public menuTopBar: Array<any>;

    constructor(private appService: AppService) {

    }

    ngOnInit() {
        this.appService.getMenu().subscribe(data => {
            this.menuTopBar = data;
        });
    }

    public changeString($strign){
        return $strign.replace(/ /g, "-");
    }

    openMegaMenu() {
        let pane = document.getElementsByClassName('cdk-overlay-pane');
        [].forEach.call(pane, function(el) {
            if (el.children.length > 0) {
                if (el.children[0].classList.contains('mega-menu')) {
                    el.classList.add('mega-menu-pane');
                }
            }
        });
    }


}
