import {Component, OnInit, Input, Output, EventEmitter} from '@angular/core';
import {Data, AppService} from '../../../app.service';
import {Settings, AppSettings} from '../../../app.settings';
import {TelephoneDialogComponent} from '../menu/telephone-dialog/telephone-dialog.component';
import {MatDialog} from '@angular/material';

@Component({
    selector: 'app-top-menu',
    templateUrl: './top-menu.component.html'
})
export class TopMenuComponent implements OnInit {
    @Output() onOpenTelephoneDialog: EventEmitter<any> = new EventEmitter();
    public currencies = ['USD', 'EUR'];
    public currency: any;

    public settings: Settings;

    constructor(public appSettings: AppSettings, public appService: AppService, public dialog: MatDialog,) {
        this.settings = this.appSettings.settings;
    }

    ngOnInit() {
        this.currency = this.currencies[0];
    }

    public changeCurrency(currency) {
        this.currency = currency;
    }



    public openTelephoneDialog() {
        let dialogRef = this.dialog.open(TelephoneDialogComponent, {
            panelClass: 'telephone-dialog',
            direction: 'ltr'
        });
    }

}
