//
//  IntroViewController.h
//  IOSAppConcoursPhoto
//
//  Created by Kerautret on 06/11/12.
//  Copyright (c) 2012 projetTutoreSRC. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "FGalleryViewController.h"


@interface IntroViewController : UITableViewController<FGalleryViewControllerDelegate>{
    NSArray *localCaptions;
    NSArray *localImages;
    NSArray *networkCaptions;
    NSArray *networkImages;
	FGalleryViewController *localGallery;
    FGalleryViewController *networkGallery;
    
}





@end
