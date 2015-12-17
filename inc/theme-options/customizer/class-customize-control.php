<?php

if( ! class_exists( 'WP_Customize_Control' ) )
	 return;

class Fruitful_Customize_Text_Control extends WP_Customize_Control {
	  public $type 			= 'text';	
	  public $info			= ''; 
	  public $top_label	= ''; 
	  public $top_info	= ''; 	  
	  public $box_title ='';
      public function render_content()   {
            ?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?><?php if(!empty ($this->top_label)):?><?php echo esc_html( $this->top_label ); ?><?php endif; ?></span>
			<?php if ( ! empty( $this->top_info ) ) : ?><span class="add_element_info"><?php echo $this->top_info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->info ) ) : ?><span class="add_element_info"><?php echo $this->info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->box_title ) ) : ?><span class="add_element_info"><?php echo $this->box_title; ?></span><?php endif; ?>
			 <input type="text" value="7000" <?php $this->link(); ?>>
		</label>
            <?php
       }
}	 
	 
class Fruitful_Customize_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';
	public $info = '';
	public $top_label	= ''; 
	public $top_info	= ''; 	
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?><?php if(!empty ($this->top_label)):?><?php echo esc_html( $this->top_label ); ?><?php endif; ?></span>
			<?php if ( ! empty( $this->top_info ) ) : ?><span class="add_element_info"><?php echo $this->top_info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->info ) ) : ?><span class="add_element_info"><?php echo $this->info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
				<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
		</label>
		<?php
	}

}

class Fruitful_Customize_Checkbox_Control extends WP_Customize_Control {
    public $type 	= 'checkbox';
	public $class	= ''; 
	public $info	= ''; 
	public $top_label	= ''; 
	public $top_info	= ''; 
    public function render_content() {
		?>
		
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?><?php if(!empty ($this->top_label)):?><?php echo esc_html( $this->top_label ); ?><?php endif; ?></span>
			<?php if ( ! empty( $this->top_info ) ) : ?><span class="add_element_info"><?php echo $this->top_info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->info ) ) : ?><span class="add_element_info"><?php echo $this->info; ?></span><?php endif; ?>
			<span class="description customize-control-description"><input type="checkbox" value="<?php echo $this->value();?>" <?php $this->link(); ?>><?php if ( ! empty( $this->description ) ) : ?><?php echo $this->description; ?><?php endif; ?></span>
		</label>	
		<?php

    }
}

class Fruitful_Customize_Select_Control extends WP_Customize_Control {
	public $type 			= 'select';
	public $info			= ''; 
	public $top_label		= ''; 
	public $top_info		= ''; 	
	public $box_title 		='';	
	public $option_block 	= '';
	public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?><?php if(!empty ($this->top_label)):?><?php echo esc_html( $this->top_label ); ?><?php endif; ?></span>
			<?php if ( ! empty( $this->top_info ) ) : ?><span class="add_element_info"><?php echo $this->top_info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->info ) ) : ?><span class="add_element_info"><?php echo $this->info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?><?php echo $this->description; ?><?php endif; ?>
			<?php if ( ! empty( $this->box_title ) ) : ?><span class="add_element_info"><?php echo $this->box_title; ?></span><?php endif; ?>
			<select  <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
				?>
			</select>
		</label>
		<?php
	} 
} 

class Fruitful_Customize_Font_Control extends WP_Customize_Control {
	public $type 		= 'font';
	public $info		= ''; 
	public $top_label	= ''; 
	public $top_info	= ''; 	
	public $box_title ='';	
	public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?><?php if(!empty ($this->top_label)):?><?php echo esc_html( $this->top_label ); ?><?php endif; ?></span>
			<?php if ( ! empty( $this->top_info ) ) : ?><span class="add_element_info"><?php echo $this->top_info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->info ) ) : ?><span class="add_element_info"><?php echo $this->info; ?></span><?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?><?php echo $this->description; ?><?php endif; ?>
			<?php if ( ! empty( $this->box_title ) ) : ?><span class="add_element_info"><?php echo $this->box_title; ?></span><?php endif; ?>
			<select  <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
				?>
			</select>
		</label>
		<?php
	} 
} 

