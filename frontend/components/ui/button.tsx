import { Slot } from "@radix-ui/react-slot";
import { cva, type VariantProps } from "class-variance-authority";
import * as React from "react";

import { cn } from "@/lib/utils";

const buttonVariants = cva(
  "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
  {
    variants: {
      variant: {
        default:
          "bg-primary/75 border border-primary-foreground/25 text-primary-foreground shadow-sm shadow-black/5 hover:bg-primary/90",
        destructive:
          "bg-destructive text-white shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40",
        outline:
          "border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground",
        secondary:
          "bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80",
        ghost: "hover:bg-accent hover:text-accent-foreground",
        link: "text-primary underline-offset-4 hover:underline",
      },
      size: {
        default: "h-9 px-4 py-2",
        sm: "h-8 rounded-md px-3 text-xs",
        lg: "h-10 rounded-md px-8",
        icon: "size-9",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

interface ButtonProps extends React.ComponentProps<"button">, VariantProps<typeof buttonVariants> {
  asChild?: boolean;
  icon?: React.ReactNode;
  iconPosition?: 'left' | 'right';
  iconOnly?: boolean;
}

function Button({
  className,
  variant,
  size,
  asChild = false,
  icon,
  iconPosition = 'left',
  iconOnly = false,
  children,
  ...props
}: ButtonProps) {
  const Comp = asChild ? Slot : "button";

  // Se for iconOnly, força o size para 'icon' e remove o gap
  const buttonSize = iconOnly ? 'icon' : size;
  const buttonClass = iconOnly 
    ? cn(buttonVariants({ variant, size: buttonSize }), "gap-0", className)
    : cn(buttonVariants({ variant, size: buttonSize, className }));

  const renderContent = () => {
    if (iconOnly) {
      return icon;
    }

    if (!icon) {
      return children;
    }

    return iconPosition === 'left' ? (
      <>
        {icon}
        {children}
      </>
    ) : (
      <>
        {children}
        {icon}
      </>
    );
  };

  return (
    <Comp
      data-slot="button"
      className={buttonClass}
      {...props}
    >
      {renderContent()}
    </Comp>
  );
}

export { Button, buttonVariants };
export type { ButtonProps };
